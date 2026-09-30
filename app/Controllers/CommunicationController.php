<?php

namespace App\Controllers;

use App\Models\NotificationTemplateModel;
use App\Models\HrAnnouncementModel;
use App\Models\SystemNotificationModel;

use App\Libraries\NotificationService;
use App\Models\EmployeeModel;

/**
 * Class CommunicationController
 *
 * Module 36: Communication, Announcements & Multi-Channel Notifications
 */
class CommunicationController extends BaseController
{
    /**
     * Communication Hub Dashboard
     */
    public function index()
    {
        $templateModel     = new NotificationTemplateModel();
        $announcementModel = new HrAnnouncementModel();
        $empModel          = new EmployeeModel();

        $templates     = $templateModel->findAll();
        $announcements = $announcementModel->getActiveAnnouncements(1);
        $employees     = $empModel->whereIn('employment_status', ['active', 'probation', 'notice_period'])->where('deleted_at', null)->findAll();

        $data = [
            'templates'     => $templates,
            'announcements' => $announcements,
            'employees'     => $employees,
        ];

        return $this->render('communication/index', $data, 'Communication & Broadcast Center');
    }

    /**
     * Broadcast New HR Announcement
     */
    public function storeAnnouncement()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to broadcast announcements.');
            return redirect()->to(site_url('communication'));
        }

        $rules = [
            'title'   => 'required|min_length[5]|max_length[180]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('communication'));
        }

        $title    = $this->request->getPost('title');
        $content  = $this->request->getPost('content');
        $audience = $this->request->getPost('target_audience') ?: 'all';
        $priority = $this->request->getPost('priority') ?: 'normal';

        $announcementModel = new HrAnnouncementModel();
        $announcementModel->insert([
            'company_id'      => 1,
            'title'           => $title,
            'content'         => $content,
            'target_audience' => $audience,
            'priority'        => $priority,
            'is_published'    => 1,
            'published_at'    => date('Y-m-d H:i:s'),
            'expires_at'      => $this->request->getPost('expires_at') ?: null,
            'created_by'      => $this->userId(),
        ]);

        // Auto-broadcast in-app notifications to staff
        $notifService = new NotificationService();
        $broadcastCount = $notifService->broadcast(
            "📢 Announcement: {$title}",
            $content,
            $audience
        );

        $this->logAudit('ANNOUNCEMENT_CREATE', 'communication', "Broadcasted announcement '{$title}' to {$broadcastCount} employees");
        $this->session->setFlashdata('success', "Announcement published and distributed to {$broadcastCount} staff members.");
        return redirect()->to(site_url('communication'));
    }

    /**
     * Test Multi-Channel Dispatcher (Email, SMS, WhatsApp, In-App)
     */
    public function testDispatch()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized to trigger notifications.');
            return redirect()->to(site_url('communication'));
        }

        $templateKey = $this->request->getPost('template_key');
        $employeeId  = (int)$this->request->getPost('employee_id');
        $channels    = (array)$this->request->getPost('channels');
        $details     = $this->request->getPost('details') ?: 'Test verification dispatch from HRMS Communication Center';

        if (empty($templateKey) || empty($employeeId) || empty($channels)) {
            $this->session->setFlashdata('error', 'Template, recipient employee, and at least one channel are required.');
            return redirect()->to(site_url('communication'));
        }

        $notifService = new NotificationService();
        $success = $notifService->send(
            $templateKey,
            $employeeId,
            ['{{DETAILS}}' => $details],
            $channels
        );

        if ($success) {
            $channelList = strtoupper(implode(', ', $channels));
            $this->logAudit('TEST_NOTIFICATION', 'communication', "Triggered {$channelList} dispatch for employee #{$employeeId} using template {$templateKey}");
            $this->session->setFlashdata('success', "Notification test successfully processed across: {$channelList}.");
        } else {
            $this->session->setFlashdata('error', 'Failed to dispatch test notification. Please verify recipient details.');
        }

        return redirect()->to(site_url('communication'));
    }
}
