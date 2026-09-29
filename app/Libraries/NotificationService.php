<?php

namespace App\Libraries;

use App\Models\NotificationTemplateModel;
use App\Models\SystemNotificationModel;
use App\Models\EmployeeModel;

class NotificationService
{
    protected NotificationTemplateModel $templateModel;
    protected SystemNotificationModel $notifModel;
    protected EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->templateModel = new NotificationTemplateModel();
        $this->notifModel    = new SystemNotificationModel();
        $this->employeeModel = new EmployeeModel();
    }

    /**
     * Dispatch notification by template key or custom payload
     *
     * @param string $templateKey
     * @param int $employeeId
     * @param array $tokens
     * @param array $channels ['in_app', 'email', 'sms', 'whatsapp']
     * @return bool
     */
    public function send(string $templateKey, int $employeeId, array $tokens = [], array $channels = ['in_app']): bool
    {
        $employee = $this->employeeModel->find($employeeId);
        if (!$employee) {
            return false;
        }

        $template = $this->templateModel->where('template_key', $templateKey)->where('is_active', 1)->first();

        $defaultTokens = [
            '{{EMPLOYEE_NAME}}' => $employee['first_name'] . ' ' . $employee['last_name'],
            '{{ACTION_DATE}}'   => date('F j, Y'),
            '{{DETAILS}}'       => $tokens['{{DETAILS}}'] ?? 'System Event',
            '{{COMPANY_NAME}}'  => 'Infosof Technologies',
        ];

        $mergedTokens = array_merge($defaultTokens, $tokens);

        $title = $template['title'] ?? 'Enterprise HRMS Alert';
        $subject = $template['subject'] ?? $title;
        $body = $template['body_content'] ?? ($tokens['{{DETAILS}}'] ?? 'You have a new update in your HRMS portal.');

        // Substitute tokens
        $subject = str_replace(array_keys($mergedTokens), array_values($mergedTokens), $subject);
        $body    = str_replace(array_keys($mergedTokens), array_values($mergedTokens), $body);

        // 1. In-App Notification (Always stored)
        if (in_array('in_app', $channels) || in_array('all', $channels)) {
            $this->notifModel->insert([
                'user_id'     => $employee['user_id'] ?? null,
                'employee_id' => $employeeId,
                'title'       => $subject,
                'message'     => $body,
                'channel'     => 'in_app',
                'is_read'     => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        // 2. Email Delivery Channel
        if (in_array('email', $channels) || in_array('all', $channels)) {
            $toEmail = $employee['official_email'] ?: $employee['email'];
            if (!empty($toEmail)) {
                $this->dispatchEmail($toEmail, $subject, $body);
            }
        }

        // 3. SMS Delivery Channel
        if (in_array('sms', $channels) || in_array('all', $channels)) {
            $phone = $employee['phone'] ?? null;
            if (!empty($phone)) {
                $this->dispatchSms($phone, $body);
            }
        }

        // 4. WhatsApp Delivery Channel
        if (in_array('whatsapp', $channels) || in_array('all', $channels)) {
            $phone = $employee['phone'] ?? null;
            if (!empty($phone)) {
                $this->dispatchWhatsApp($phone, $body);
            }
        }

        return true;
    }

    /**
     * Send email via CodeIgniter email service or fallback log
     */
    protected function dispatchEmail(string $to, string $subject, string $message): bool
    {
        try {
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setFrom('hrms-notifications@infosof.local', 'Infosof HRMS');
            $email->setSubject($subject);
            $email->setMessage($message);
            
            if (!@$email->send(false)) {
                log_message('info', "Email to {$to}: {$subject} (Logged via NotificationService)");
            }
            return true;
        } catch (\Throwable $e) {
            log_message('error', "NotificationService Email Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Dispatch SMS via Gateway or Audit Log
     */
    protected function dispatchSms(string $phone, string $message): bool
    {
        log_message('info', "SMS dispatched to {$phone}: " . substr($message, 0, 140));
        return true;
    }

    /**
     * Dispatch WhatsApp Business Alert
     */
    protected function dispatchWhatsApp(string $phone, string $message): bool
    {
        log_message('info', "WhatsApp message dispatched to {$phone}: " . substr($message, 0, 140));
        return true;
    }

    /**
     * Broadcast notification to all active employees or specific audience
     */
    public function broadcast(string $title, string $message, string $targetAudience = 'all', ?int $targetId = null): int
    {
        $builder = $this->employeeModel->where('employment_status', 'active')->where('deleted_at', null);

        if ($targetAudience === 'department' && $targetId) {
            $builder->where('department_id', $targetId);
        } elseif ($targetAudience === 'branch' && $targetId) {
            $builder->where('branch_id', $targetId);
        }

        $employees = $builder->findAll();
        $count = 0;

        foreach ($employees as $emp) {
            $this->notifModel->insert([
                'user_id'     => $emp['user_id'] ?? null,
                'employee_id' => $emp['id'],
                'title'       => $title,
                'message'     => $message,
                'channel'     => 'in_app',
                'is_read'     => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Get unread notifications for currently logged in employee
     */
    public function getUnread(int $employeeId, int $limit = 8): array
    {
        return $this->notifModel
            ->where('employee_id', $employeeId)
            ->where('is_read', 0)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Mark all notifications as read for employee
     */
    public function markAllAsRead(int $employeeId): bool
    {
        $db = \Config\Database::connect();
        return $db->table('system_notifications')
            ->where('employee_id', $employeeId)
            ->update(['is_read' => 1]);
    }
}
