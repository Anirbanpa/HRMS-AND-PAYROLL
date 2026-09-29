<?php

namespace App\Controllers;

use App\Models\BonusSchemeModel;
use App\Models\EmployeeIncentiveModel;
use App\Models\EmployeeModel;

/**
 * Class BonusController
 *
 * Module 25: Bonus, Incentive & Sales Commission Management
 */
class BonusController extends BaseController
{
    /**
     * Bonus & Incentives Operations Dashboard
     */
    public function index()
    {
        $schemeModel    = new BonusSchemeModel();
        $incentiveModel = new EmployeeIncentiveModel();
        $employeeModel  = new EmployeeModel();

        $schemes    = $schemeModel->findAll();
        $employees  = $employeeModel->where('employment_status', 'active')->findAll();
        $incentives = $incentiveModel->getDetailedIncentives();

        $totalAllocated = 0.0;
        $totalPaid      = 0.0;

        foreach ($incentives as $inc) {
            $totalAllocated += (float)$inc['final_amount'];
            if (in_array($inc['status'], ['payroll_batched', 'paid'])) {
                $totalPaid += (float)$inc['final_amount'];
            }
        }

        $data = [
            'schemes'        => $schemes,
            'employees'      => $employees,
            'incentives'     => $incentives,
            'totalAllocated' => $totalAllocated,
            'totalPaid'      => $totalPaid,
        ];

        return $this->render('bonuses/index', $data, 'Bonus, Incentives & Sales Commissions');
    }

    /**
     * Create Incentive Entry for Employee
     */
    public function storeEntry()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'payroll_manager', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to assign incentives.');
            return redirect()->to(site_url('bonuses'));
        }

        $rules = [
            'employee_id'      => 'required|numeric',
            'bonus_scheme_id'  => 'required|numeric',
            'reference_period' => 'required',
            'final_amount'     => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('bonuses'));
        }

        $incentiveModel = new EmployeeIncentiveModel();
        $amount = (float)$this->request->getPost('final_amount');

        $incentiveModel->insert([
            'employee_id'       => (int)$this->request->getPost('employee_id'),
            'bonus_scheme_id'   => (int)$this->request->getPost('bonus_scheme_id'),
            'reference_period'  => $this->request->getPost('reference_period'),
            'target_achieved'   => (float)($this->request->getPost('target_achieved') ?: 0.00),
            'calculated_amount' => $amount,
            'final_amount'      => $amount,
            'notes'             => $this->request->getPost('notes'),
            'status'            => 'hr_approved',
            'approved_by'       => $this->userId(),
            'approved_at'       => date('Y-m-d H:i:s'),
        ]);

        $this->logAudit('BONUS_ENTRY_ADD', 'bonuses', "Allocated ₹{$amount} incentive to Employee ID {$this->request->getPost('employee_id')}");
        $this->session->setFlashdata('success', 'Incentive entry logged and approved for payroll batching.');
        return redirect()->to(site_url('bonuses'));
    }
}
