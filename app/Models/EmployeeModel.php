<?php

namespace App\Models;

class EmployeeModel extends BaseModel
{
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'user_id',
        'company_id',
        'branch_id',
        'department_id',
        'designation_id',
        'pay_grade_id',
        'employee_code',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'official_email',
        'phone',
        'gender',
        'date_of_birth',
        'marital_status',
        'blood_group',
        'joining_date',
        'confirmation_date',
        'probation_end_date',
        'employment_type',
        'employment_status',
        'reporting_to',
        'present_address',
        'permanent_address',
        'city',
        'state',
        'country',
        'postal_code',
        'national_id_ssn',
        'tax_identification_number',
        'passport_number',
        'driving_license',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'profile_photo',
    ];

    /**
     * Get paginated employees with full joined relations
     *
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getDetailedList(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->select('employees.*, 
            dept.name as department_name, dept.code as department_code,
            desig.name as designation_name,
            br.name as branch_name, br.city as branch_city,
            pg.grade_name, pg.grade_code,
            mgr.first_name as manager_first_name, mgr.last_name as manager_last_name, mgr.employee_code as manager_code,
            u.username, u.status as user_status, r.name as role_name')
            ->join('departments dept', 'dept.id = employees.department_id', 'left')
            ->join('designations desig', 'desig.id = employees.designation_id', 'left')
            ->join('branches br', 'br.id = employees.branch_id', 'left')
            ->join('pay_grades pg', 'pg.id = employees.pay_grade_id', 'left')
            ->join('employees mgr', 'mgr.id = employees.reporting_to', 'left')
            ->join('users u', 'u.employee_id = employees.id', 'left')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('employees.deleted_at', null);

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $builder->groupStart()
                ->like('employees.first_name', $s)
                ->orLike('employees.last_name', $s)
                ->orLike('employees.employee_code', $s)
                ->orLike('employees.email', $s)
            ->groupEnd();
        }

        if (!empty($filters['department_id'])) {
            $builder->where('employees.department_id', $filters['department_id']);
        }

        if (!empty($filters['branch_id'])) {
            $builder->where('employees.branch_id', $filters['branch_id']);
        }

        if (!empty($filters['employment_status'])) {
            $builder->where('employees.employment_status', $filters['employment_status']);
        }

        return $builder->orderBy('employees.id', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    /**
     * Get a comprehensive 360 degree profile of an employee
     *
     * @param int $id
     * @return array|null
     */
    public function get360Profile(int $id): ?array
    {
        $employee = $this->select('employees.*, 
            dept.name as department_name, dept.code as department_code,
            desig.name as designation_name,
            br.name as branch_name, br.city as branch_city, br.country as branch_country,
            pg.grade_name, pg.min_salary, pg.max_salary,
            mgr.first_name as manager_first_name, mgr.last_name as manager_last_name, mgr.email as manager_email,
            u.id as user_id, u.username, u.role_id, r.name as role_name')
            ->join('departments dept', 'dept.id = employees.department_id', 'left')
            ->join('designations desig', 'desig.id = employees.designation_id', 'left')
            ->join('branches br', 'br.id = employees.branch_id', 'left')
            ->join('pay_grades pg', 'pg.id = employees.pay_grade_id', 'left')
            ->join('employees mgr', 'mgr.id = employees.reporting_to', 'left')
            ->join('users u', 'u.employee_id = employees.id', 'left')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('employees.id', $id)
            ->where('employees.deleted_at', null)
            ->first();

        if (!$employee) {
            return null;
        }

        $db = \Config\Database::connect();

        // Bank details
        $employee['bank_details'] = $db->table('employee_bank_details')
            ->where('employee_id', $id)
            ->get()
            ->getResultArray();

        // Salary structure
        $employee['salary_structure'] = $db->table('salary_structures')
            ->where('employee_id', $id)
            ->orderBy('effective_date', 'DESC')
            ->get()
            ->getFirstRow('array');

        // Leave balances
        $currentYear = date('Y');
        $employee['leave_balances'] = $db->table('leave_balances lb')
            ->select('lb.*, lt.name as leave_type_name, lt.code as leave_type_code, lt.is_paid')
            ->join('leave_types lt', 'lt.id = lb.leave_type_id')
            ->where('lb.employee_id', $id)
            ->where('lb.year', $currentYear)
            ->get()
            ->getResultArray();

        // Recent attendance (last 7 days)
        $employee['recent_attendance'] = $db->table('attendance')
            ->where('employee_id', $id)
            ->orderBy('date', 'DESC')
            ->limit(7)
            ->get()
            ->getResultArray();

        // Documents
        $employee['documents'] = $db->table('employee_documents')
            ->where('employee_id', $id)
            ->orderBy('uploaded_at', 'DESC')
            ->get()
            ->getResultArray();

        return $employee;
    }

    /**
     * Generate next incremental employee code (e.g. EMP0014)
     *
     * @return string
     */
    public function generateEmployeeCode(): string
    {
        $db = \Config\Database::connect();
        $rows = $db->table('employees')
            ->select('employee_code')
            ->get()
            ->getResultArray();

        $maxNum = 0;
        foreach ($rows as $r) {
            if (preg_match('/^EMP0*(\d+)$/i', $r['employee_code'], $matches)) {
                $num = (int)$matches[1];
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }

        $nextNum = $maxNum + 1;
        do {
            $code = 'EMP' . str_pad((string)$nextNum, 4, '0', STR_PAD_LEFT);
            $exists = $this->where('employee_code', $code)->withDeleted()->first();
            $nextNum++;
        } while ($exists);

        return $code;
    }
}
