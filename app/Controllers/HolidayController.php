<?php

namespace App\Controllers;

use App\Models\HolidayModel;
use App\Models\WorkingDayConfigModel;
use App\Models\BranchModel;
use App\Models\DepartmentModel;

/**
 * Class HolidayController
 *
 * Module 14: Holiday Calendar & Working Day Configurations
 */
class HolidayController extends BaseController
{
    /**
     * Holiday Calendar & Working Days Setup Dashboard
     */
    public function index()
    {
        $holidayModel    = new HolidayModel();
        $workingDayModel = new WorkingDayConfigModel();
        $branchModel     = new BranchModel();
        $departmentModel = new DepartmentModel();

        $selectedYear = (int)($this->request->getGet('year') ?: date('Y'));
        $branchId     = $this->request->getGet('branch_id') ? (int)$this->request->getGet('branch_id') : null;
        $deptId       = $this->request->getGet('department_id') ? (int)$this->request->getGet('department_id') : null;

        $holidays    = $holidayModel->getHolidaysByScope($selectedYear, $branchId, $deptId);
        $workingDays = $workingDayModel->where('company_id', 1)->findAll();
        $branches    = $branchModel->findAll();
        $departments = $departmentModel->findAll();

        $data = [
            'holidays'     => $holidays,
            'workingDays'  => $workingDays,
            'branches'     => $branches,
            'departments'  => $departments,
            'selectedYear' => $selectedYear,
            'branchId'     => $branchId,
            'deptId'       => $deptId,
        ];

        return $this->render('holidays/index', $data, 'Holiday Calendar & Working Schedule');
    }

    /**
     * Store new Holiday Entry
     */
    public function store()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized to manage holidays.');
            return redirect()->to(site_url('holidays'));
        }

        $rules = [
            'title'        => 'required|min_length[3]|max_length[100]',
            'date'         => 'required|valid_date',
            'holiday_type' => 'required|in_list[national,regional,company,restricted,optional]',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('holidays'));
        }

        $holidayModel = new HolidayModel();
        $holidayModel->insert([
            'company_id'     => 1,
            'branch_id'      => $this->request->getPost('branch_id') ?: null,
            'department_id'  => $this->request->getPost('department_id') ?: null,
            'title'          => $this->request->getPost('title'),
            'holiday_type'   => $this->request->getPost('holiday_type'),
            'date'           => $this->request->getPost('date'),
            'is_recurring'   => $this->request->getPost('is_recurring') ? 1 : 0,
            'is_working_day' => $this->request->getPost('is_working_day') ? 1 : 0,
            'description'    => $this->request->getPost('description'),
        ]);

        $this->logAudit('HOLIDAY_CREATE', 'holidays', "Added holiday {$this->request->getPost('title')} on {$this->request->getPost('date')}");
        $this->session->setFlashdata('success', 'Holiday added to calendar.');
        return redirect()->to(site_url('holidays'));
    }

    /**
     * Delete Holiday Entry
     */
    public function delete($id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to delete holidays.');
            return redirect()->to(site_url('holidays'));
        }

        $holidayModel = new HolidayModel();
        $holidayModel->delete((int)$id);

        $this->logAudit('HOLIDAY_DELETE', 'holidays', "Deleted holiday ID {$id}");
        $this->session->setFlashdata('success', 'Holiday removed successfully.');
        return redirect()->to(site_url('holidays'));
    }

    /**
     * Update Organizational Working Day Configurations
     */
    public function updateWorkingDays()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to configure working days.');
            return redirect()->to(site_url('holidays'));
        }

        $workingDayModel = new WorkingDayConfigModel();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            $isWorking   = $this->request->getPost("is_working_{$day}") ? 1 : 0;
            $workingType = $this->request->getPost("working_type_{$day}") ?: 'full_day';
            $altOff      = $this->request->getPost("alternate_{$day}") ?: null;

            $existing = $workingDayModel->where('company_id', 1)->where('day_of_week', $day)->first();
            if ($existing) {
                $workingDayModel->update($existing['id'], [
                    'is_working'         => $isWorking,
                    'working_type'       => $workingType,
                    'alternate_week_off' => $altOff,
                ]);
            } else {
                $workingDayModel->insert([
                    'company_id'         => 1,
                    'day_of_week'        => $day,
                    'is_working'         => $isWorking,
                    'working_type'       => $workingType,
                    'alternate_week_off' => $altOff,
                ]);
            }
        }

        $this->logAudit('WORKING_DAYS_UPDATE', 'holidays', 'Updated organizational working days schedule');
        $this->session->setFlashdata('success', 'Working day configurations updated.');
        return redirect()->to(site_url('holidays'));
    }
}
