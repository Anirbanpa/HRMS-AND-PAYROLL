<?php

namespace App\Controllers;

use App\Models\CompanyPolicyModel;
use App\Models\PolicyAcknowledgementModel;

/**
 * Class PolicyController
 *
 * Module 38: HR Policies, Circulars & Knowledge Center
 */
class PolicyController extends BaseController
{
    /**
     * Policy Repository & Handbook Dashboard
     */
    public function index()
    {
        $policyModel = new CompanyPolicyModel();
        $employeeId  = $this->currentUser['employee_id'] ?? 0;

        $policies = $policyModel->getPoliciesWithEmployeeStatus((int)$employeeId, 1);

        $data = [
            'policies' => $policies,
        ];

        return $this->render('policies/index', $data, 'HR Policies & Knowledge Repository');
    }

    /**
     * Acknowledge Policy (Compliance Sign-off)
     */
    public function acknowledge($id)
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee linked.');
            return redirect()->to(site_url('policies'));
        }

        $ackModel = new PolicyAcknowledgementModel();
        $existing = $ackModel->where('policy_id', (int)$id)->where('employee_id', $employeeId)->first();

        if (!$existing) {
            $ackModel->insert([
                'policy_id'       => (int)$id,
                'employee_id'     => $employeeId,
                'acknowledged_at' => date('Y-m-d H:i:s'),
                'ip_address'      => $this->request->getIPAddress(),
                'user_agent'      => $this->request->getUserAgent()->getAgentString(),
            ]);
            $this->logAudit('POLICY_ACKNOWLEDGE', 'policies', "Employee ID {$employeeId} signed policy ID {$id}");
            $this->session->setFlashdata('success', 'Policy acknowledged successfully.');
        }

        return redirect()->to(site_url('policies'));
    }
}
