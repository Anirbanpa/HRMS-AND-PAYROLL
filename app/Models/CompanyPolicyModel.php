<?php

namespace App\Models;

/**
 * Class CompanyPolicyModel
 *
 * Module 38: HR Policies, Circulars & Employee Handbook
 */
class CompanyPolicyModel extends BaseModel
{
    protected $table         = 'company_policies';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'policy_code',
        'title',
        'category',
        'version',
        'effective_date',
        'file_path',
        'summary',
        'content',
        'requires_acknowledgement',
        'department_restriction_id',
        'status',
        'published_at',
    ];

    /**
     * Get published policies with employee acknowledgement status
     *
     * @param int $employeeId
     * @param int $companyId
     * @return array
     */
    public function getPoliciesWithEmployeeStatus(int $employeeId, int $companyId = 1): array
    {
        return $this->select('company_policies.*, 
                pa.acknowledged_at, 
                IF(pa.id IS NOT NULL, 1, 0) as is_acknowledged')
            ->join('policy_acknowledgements pa', "pa.policy_id = company_policies.id AND pa.employee_id = {$employeeId}", 'left')
            ->where('company_policies.company_id', $companyId)
            ->where('company_policies.status', 'published')
            ->orderBy('company_policies.category', 'ASC')
            ->orderBy('company_policies.title', 'ASC')
            ->findAll();
    }
}
