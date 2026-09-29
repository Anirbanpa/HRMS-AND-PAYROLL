<?php

namespace App\Models;

class AssetAllocationModel extends BaseModel
{
    protected $table            = 'asset_allocations';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'asset_id',
        'employee_id',
        'allocated_at',
        'returned_at',
        'condition_on_allocation',
        'condition_on_return',
        'allocated_by',
        'notes',
    ];

    public function getAllocationsWithDetails(int $assetId = 0): array
    {
        $builder = $this->select('asset_allocations.*, assets.name AS asset_name, assets.asset_code, employees.first_name, employees.last_name, employees.employee_code')
                        ->join('assets', 'assets.id = asset_allocations.asset_id', 'left')
                        ->join('employees', 'employees.id = asset_allocations.employee_id', 'left');

        if ($assetId > 0) {
            $builder->where('asset_allocations.asset_id', $assetId);
        }

        return $builder->orderBy('asset_allocations.id', 'DESC')->findAll();
    }
}
