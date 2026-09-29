<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class AuditController extends BaseController
{
    public function index()
    {
        if (!$this->hasPermission('audit.view')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view audit trail logs.');
            return redirect()->to(site_url('dashboard'));
        }

        $logModel = new ActivityLogModel();
        $logs = $logModel->getRecentLogs(100);

        $data = [
            'logs' => $logs,
        ];

        return $this->render('audit/index', $data, 'System Audit Trail & Security Logs');
    }
}
