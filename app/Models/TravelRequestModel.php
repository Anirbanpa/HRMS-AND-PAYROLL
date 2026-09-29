<?php

namespace App\Models;

/**
 * Class TravelRequestModel
 *
 * Module 39: Business Travel Authorizations & Advances
 */
class TravelRequestModel extends BaseModel
{
    protected $table         = 'travel_requests';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'request_number',
        'employee_id',
        'purpose',
        'travel_type',
        'source_city',
        'destination_city',
        'start_date',
        'end_date',
        'estimated_budget',
        'advance_required',
        'advance_disbursed',
        'notes',
        'status',
        'manager_id',
        'manager_action_at',
        'manager_remarks',
        'finance_id',
        'finance_action_at',
        'finance_remarks',
    ];

    /**
     * Get detailed travel requests with employee and claims summary
     *
     * @param array $filters
     * @return array
     */
    public function getDetailedTravels(array $filters = []): array
    {
        $builder = $this->select('travel_requests.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                m.first_name as manager_first_name, m.last_name as manager_last_name')
            ->join('employees e', 'e.id = travel_requests.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('employees m', 'm.id = travel_requests.manager_id', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('travel_requests.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('travel_requests.status', $filters['status']);
        }

        return $builder->orderBy('travel_requests.id', 'DESC')->findAll();
    }
}
