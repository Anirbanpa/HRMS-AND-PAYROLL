<?php

namespace App\Models;

class ActivityLogModel extends BaseModel
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'user_id',
        'action',
        'module',
        'description',
        'record_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Log a tamper-resistant enterprise audit event
     *
     * @param int|null $userId
     * @param string $action
     * @param string $module
     * @param string $description
     * @param int|null $recordId
     * @param string|null $ip
     * @param string|null $userAgent
     * @return int|string|bool
     */
    public function recordEvent(?int $userId, string $action, string $module, string $description, ?int $recordId = null, ?string $ip = null, ?string $userAgent = null)
    {
        return $this->insert([
            'user_id'     => $userId,
            'action'      => strtoupper($action),
            'module'      => strtolower($module),
            'description' => $description,
            'record_id'   => $recordId,
            'ip_address'  => $ip ?? service('request')->getIPAddress(),
            'user_agent'  => substr($userAgent ?? service('request')->getUserAgent()->getAgentString(), 0, 255),
        ]);
    }

    /**
     * Get recent logs joined with username and employee name
     *
     * @param int $limit
     * @return array
     */
    public function getRecentLogs(int $limit = 50): array
    {
        return $this->select('activity_logs.*, u.username, u.email, emp.first_name, emp.last_name, emp.employee_code')
            ->join('users u', 'u.id = activity_logs.user_id', 'left')
            ->join('employees emp', 'emp.id = u.employee_id', 'left')
            ->orderBy('activity_logs.id', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
