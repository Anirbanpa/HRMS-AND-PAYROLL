<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\AssetAllocationModel;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\ResponseInterface;

class AssetController extends BaseController
{
    protected AssetModel $assetModel;
    protected AssetAllocationModel $allocModel;
    protected EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
        $this->allocModel = new AssetAllocationModel();
        $this->employeeModel = new EmployeeModel();
    }

    /**
     * Asset Management Overview & Registry
     */
    public function index(): string
    {
        $statusFilter = $this->request->getGet('status') ?? '';
        $categoryFilter = $this->request->getGet('category') ?? '';

        $filters = [];
        if (!empty($statusFilter)) $filters['status'] = $statusFilter;
        if (!empty($categoryFilter)) $filters['category'] = $categoryFilter;

        $assets = $this->assetModel->getAssetsWithAssigned($filters);
        $employees = $this->employeeModel->where('deleted_at', null)->orderBy('first_name', 'ASC')->findAll();
        $allocations = $this->allocModel->getAllocationsWithDetails();

        // Calculate KPI Metrics
        $totalAssets = count($assets);
        $totalValuation = array_sum(array_column($assets, 'purchase_cost'));
        $allocatedCount = count(array_filter($assets, fn($a) => $a['status'] === 'allocated'));
        $availableCount = count(array_filter($assets, fn($a) => $a['status'] === 'available'));
        $maintenanceCount = count(array_filter($assets, fn($a) => in_array($a['status'], ['maintenance', 'retired'])));

        $data = [
            'pageTitle'        => 'Hardware & Digital Asset Management',
            'assets'           => $assets,
            'employees'        => $employees,
            'allocations'      => $allocations,
            'totalAssets'      => $totalAssets,
            'totalValuation'   => $totalValuation,
            'allocatedCount'   => $allocatedCount,
            'availableCount'   => $availableCount,
            'maintenanceCount' => $maintenanceCount,
            'statusFilter'     => $statusFilter,
            'categoryFilter'   => $categoryFilter,
        ];

        return $this->render('assets/index', $data);
    }

    /**
     * Store a new Asset in inventory
     */
    public function store(): ResponseInterface
    {
        $name = trim($this->request->getPost('name') ?? '');
        $category = $this->request->getPost('category') ?: 'laptop';
        $brand = trim($this->request->getPost('brand') ?? '');
        $model = trim($this->request->getPost('model') ?? '');
        $serial = trim($this->request->getPost('serial_number') ?? '');
        $cost = (float)$this->request->getPost('purchase_cost');
        $purchaseDate = $this->request->getPost('purchase_date') ?: date('Y-m-d');
        $warranty = $this->request->getPost('warranty_expiry');
        $condition = $this->request->getPost('condition_status') ?: 'good';

        if (empty($name) || empty($serial)) {
            return redirect()->back()->with('error', 'Asset Name and Serial Number are strictly required.');
        }

        // Check Serial Uniqueness
        $existing = $this->assetModel->where('serial_number', $serial)->first();
        if ($existing) {
            return redirect()->back()->with('error', "An asset with serial number '{$serial}' is already registered.");
        }

        // Generate Asset Code (e.g. AST-LAP-005)
        $prefix = strtoupper(substr($category, 0, 3));
        $count = $this->assetModel->countAllResults() + 1;
        $assetCode = "AST-{$prefix}-" . str_pad((string)$count, 3, '0', STR_PAD_LEFT);

        $this->assetModel->insert([
            'asset_code'       => $assetCode,
            'name'             => $name,
            'category'         => $category,
            'brand'            => $brand,
            'model'            => $model,
            'serial_number'    => $serial,
            'purchase_date'    => $purchaseDate,
            'purchase_cost'    => $cost,
            'warranty_expiry'  => !empty($warranty) ? $warranty : null,
            'status'           => 'available',
            'condition_status' => $condition,
        ]);

        $newId = (int)$this->assetModel->getInsertID();
        $this->logAudit('CREATE_ASSET', 'assets', "Registered asset {$assetCode} ({$name})", $newId);

        return redirect()->to(site_url('asset-management'))->with('success', "Asset {$assetCode} ({$name}) registered in inventory.");
    }

    /**
     * Handover / Allocate an Asset to an Employee
     */
    public function allocate(): ResponseInterface
    {
        $assetId = (int)$this->request->getPost('asset_id');
        $employeeId = (int)$this->request->getPost('employee_id');
        $condition = trim($this->request->getPost('condition_on_allocation') ?? 'Good working condition');
        $notes = trim($this->request->getPost('notes') ?? '');

        $asset = $this->assetModel->find($assetId);
        $employee = $this->employeeModel->find($employeeId);

        if (!$asset || !$employee) {
            return redirect()->back()->with('error', 'Invalid asset or employee specified.');
        }

        if ($asset['status'] === 'allocated') {
            return redirect()->back()->with('error', "Asset {$asset['asset_code']} is already allocated to another employee.");
        }

        // Record Allocation
        $this->allocModel->insert([
            'asset_id'                => $assetId,
            'employee_id'             => $employeeId,
            'allocated_at'            => date('Y-m-d H:i:s'),
            'condition_on_allocation' => $condition,
            'allocated_by'            => $this->userId(),
            'notes'                   => $notes,
        ]);

        // Update Asset
        $this->assetModel->update($assetId, [
            'current_employee_id' => $employeeId,
            'status'              => 'allocated',
        ]);

        $this->logAudit('ALLOCATE_ASSET', 'assets', "Allocated asset {$asset['asset_code']} to {$employee['first_name']} {$employee['last_name']}", $assetId);

        return redirect()->to(site_url('asset-management'))->with('success', "Asset {$asset['asset_code']} successfully allocated to {$employee['first_name']} {$employee['last_name']}.");
    }

    /**
     * Return an Asset from an Employee
     */
    public function returnAsset(): ResponseInterface
    {
        $assetId = (int)$this->request->getPost('asset_id');
        $conditionReturn = trim($this->request->getPost('condition_on_return') ?? 'Good condition');
        $newStatus = $this->request->getPost('asset_status') ?: 'available';

        $asset = $this->assetModel->find($assetId);
        if (!$asset) {
            return redirect()->back()->with('error', 'Asset not found.');
        }

        // Find active open allocation
        $openAlloc = $this->allocModel->where('asset_id', $assetId)->where('returned_at', null)->first();
        if ($openAlloc) {
            $this->allocModel->update($openAlloc['id'], [
                'returned_at'         => date('Y-m-d H:i:s'),
                'condition_on_return' => $conditionReturn,
            ]);
        }

        // Update Asset
        $this->assetModel->update($assetId, [
            'current_employee_id' => null,
            'status'              => $newStatus,
            'condition_status'    => ($newStatus === 'maintenance') ? 'damaged' : 'good',
        ]);

        $this->logAudit('RETURN_ASSET', 'assets', "Returned asset {$asset['asset_code']} as " . ucfirst($newStatus) . " (Condition: {$conditionReturn})", $assetId);

        return redirect()->to(site_url('asset-management'))->with('success', "Asset {$asset['asset_code']} returned and marked as " . ucfirst($newStatus) . ".");
    }
}
