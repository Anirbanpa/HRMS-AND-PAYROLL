<?php

namespace App\Models;

class AssetModel extends BaseModel
{
    protected $table            = 'assets';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'asset_code',
        'name',
        'category',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'warranty_expiry',
        'current_employee_id',
        'status',
        'condition_status',
        'notes',
    ];

    public function getAssetsWithAssigned(array $filters = []): array
    {
        $builder = $this->select('assets.*, employees.employee_code, employees.first_name, employees.last_name, departments.name AS department_name')
                        ->join('employees', 'employees.id = assets.current_employee_id', 'left')
                        ->join('departments', 'departments.id = employees.department_id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('assets.status', $filters['status']);
        }
        if (!empty($filters['category'])) {
            $builder->where('assets.category', $filters['category']);
        }

        return $builder->orderBy('assets.id', 'DESC')->findAll();
    }
}
