<?php

namespace App\Models;

class DepartmentModel extends BaseModel
{
    protected $table            = 'departments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'company_id',
        'branch_id',
        'name',
        'code',
        'head_employee_id',
        'parent_id',
        'status',
    ];

    /**
     * Get departments with head employee name and total employees count
     *
     * @return array
     */
    public function getDepartmentsWithStats(): array
    {
        $db = \Config\Database::connect();
        return $db->table('departments d')
            ->select('d.*, 
                     br.name as branch_name, 
                     parent.name as parent_dept_name,
                     head.first_name as head_first_name, head.last_name as head_last_name, head.employee_code as head_code,
                     COUNT(emp.id) as employee_count')
            ->join('branches br', 'br.id = d.branch_id', 'left')
            ->join('departments parent', 'parent.id = d.parent_id', 'left')
            ->join('employees head', 'head.id = d.head_employee_id', 'left')
            ->join('employees emp', 'emp.department_id = d.id AND emp.deleted_at IS NULL', 'left')
            ->groupBy('d.id')
            ->orderBy('d.name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
