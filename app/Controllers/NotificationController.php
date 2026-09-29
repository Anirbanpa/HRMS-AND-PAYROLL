<?php

namespace App\Controllers;

use App\Libraries\NotificationService;
use CodeIgniter\HTTP\ResponseInterface;

class NotificationController extends BaseController
{
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    /**
     * View all user notifications
     */
    public function index()
    {
        $empId  = $this->currentUser['employee_id'] ?? null;
        $userId = $this->currentUser['id'] ?? null;
        $db = \Config\Database::connect();

        $notifications = [];
        if ($empId || $userId) {
            try {
                $builder = $db->table('system_notifications');
                if ($empId && $userId) {
                    $builder->groupStart()->where('employee_id', $empId)->orWhere('user_id', $userId)->groupEnd();
                } elseif ($empId) {
                    $builder->where('employee_id', $empId);
                } else {
                    $builder->where('user_id', $userId);
                }
                $notifications = $builder->orderBy('id', 'DESC')
                    ->limit(50)
                    ->get()
                    ->getResultArray();
            } catch (\Throwable $e) {
                log_message('warning', 'Notification query failed: ' . $e->getMessage());
            }
        }

        $data = [
            'notifications' => $notifications,
            'pageTitle'     => 'Notifications & System Alerts',
        ];

        return $this->render('notifications/index', $data);
    }

    /**
     * Mark all as read via AJAX or POST
     */
    public function markAllRead(): ResponseInterface
    {
        $empId  = $this->currentUser['employee_id'] ?? null;
        $userId = $this->currentUser['id'] ?? null;
        
        try {
            $db = \Config\Database::connect();
            if ($empId || $userId) {
                $builder = $db->table('system_notifications');
                if ($empId && $userId) {
                    $builder->groupStart()->where('employee_id', $empId)->orWhere('user_id', $userId)->groupEnd();
                } elseif ($empId) {
                    $builder->where('employee_id', $empId);
                } else {
                    $builder->where('user_id', $userId);
                }
                $builder->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
            }
        } catch (\Throwable $e) {
            log_message('warning', 'Mark all read failed: ' . $e->getMessage());
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
