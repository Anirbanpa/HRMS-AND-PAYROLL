<?php

namespace App\Models;

/**
 * Class HrAnnouncementModel
 *
 * Module 36: Corporate Broadcasts & Targeted HR Announcements
 */
class HrAnnouncementModel extends BaseModel
{
    protected $table         = 'hr_announcements';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'title',
        'content',
        'target_audience',
        'target_id',
        'priority',
        'is_published',
        'published_at',
        'expires_at',
        'attachment_path',
        'created_by',
    ];

    /**
     * Get active announcements visible to a user
     *
     * @param int $companyId
     * @param int|null $departmentId
     * @param int|null $branchId
     * @return array
     */
    public function getActiveAnnouncements(int $companyId = 1, ?int $departmentId = null, ?int $branchId = null): array
    {
        return $this->select('hr_announcements.*, u.username as publisher_name')
            ->join('users u', 'u.id = hr_announcements.created_by', 'left')
            ->where('hr_announcements.company_id', $companyId)
            ->where('hr_announcements.is_published', 1)
            ->groupStart()
                ->where('hr_announcements.expires_at >=', date('Y-m-d'))
                ->orWhere('hr_announcements.expires_at', null)
            ->groupEnd()
            ->orderBy("CASE WHEN hr_announcements.priority = 'urgent' THEN 1 ELSE 0 END", 'DESC', false)
            ->orderBy('hr_announcements.published_at', 'DESC')
            ->findAll();
    }
}
