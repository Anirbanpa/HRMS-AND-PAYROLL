<?php

namespace App\Models;

class BranchModel extends BaseModel
{
    protected $table            = 'branches';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'company_id',
        'name',
        'branch_code',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'is_head_office',
        'status',
    ];

    public function getBranchesWithStats(): array
    {
        $db = \Config\Database::connect();
        return $db->table('branches b')
            ->select('b.*, COUNT(e.id) as employee_count')
            ->join('employees e', 'e.branch_id = b.id AND e.deleted_at IS NULL', 'left')
            ->groupBy('b.id')
            ->orderBy('b.is_head_office', 'DESC')
            ->orderBy('b.name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
