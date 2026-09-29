<?php

namespace App\Models;

/**
 * Class SystemNotificationModel
 *
 * Module 36: In-App User Notifications & Alert Delivery Log
 */
class SystemNotificationModel extends BaseModel
{
    protected $table         = 'system_notifications';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'employee_id',
        'title',
        'message',
        'channel',
        'action_url',
        'is_read',
        'read_at',
        'status',
    ];

    /**
     * Get unread notifications for a specific user
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getUnreadForUser(int $userId, int $limit = 10): array
    {
        return $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
