<?php

namespace App\Models;

class DesignationModel extends BaseModel
{
    protected $table            = 'designations';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'company_id',
        'department_id',
        'name',
        'code',
        'grade_band_id',
        'description',
        'status',
    ];

    public function getDesignationsWithDetails(): array
    {
        return $this->select('designations.*, 
                             dept.name as department_name, 
                             pg.grade_name, pg.grade_code, pg.min_salary, pg.max_salary')
            ->join('departments dept', 'dept.id = designations.department_id', 'left')
            ->join('pay_grades pg', 'pg.id = designations.grade_band_id', 'left')
            ->orderBy('designations.name', 'ASC')
            ->findAll();
    }

    /**
     * Get designations with department, pay grade, and assigned employee count
     */
    public function getDesignationsWithStats(): array
    {
        $db = \Config\Database::connect();
        return $db->table('designations desig')
            ->select('desig.*, 
                     dept.name as department_name, 
                     dept.code as department_code,
                     pg.grade_name, pg.grade_code, pg.min_salary, pg.max_salary,
                     COUNT(emp.id) as employee_count')
            ->join('departments dept', 'dept.id = desig.department_id', 'left')
            ->join('pay_grades pg', 'pg.id = desig.grade_band_id', 'left')
            ->join('employees emp', 'emp.designation_id = desig.id AND emp.deleted_at IS NULL', 'left')
            ->groupBy('desig.id')
            ->orderBy('desig.name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
