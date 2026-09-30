<?php

namespace App\Controllers;

use App\Models\ShiftModel;
use App\Models\ShiftAllocationModel;
use App\Models\EmployeeModel;
use App\Models\DepartmentModel;

/**
 * Class ShiftController
 *
 * Module 12: Shift Management & Rotational Roster
 */
class ShiftController extends BaseController
{
    /**
     * Shifts & Rotational Schedules Dashboard
     */
    public function index()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive', 'manager'])) {
            $this->session->setFlashdata('error', 'Access Denied: Shift scheduling is restricted to Managers and HR Administration.');
            return redirect()->to(site_url('dashboard'));
        }

        $shiftModel      = new ShiftModel();
        $allocationModel = new ShiftAllocationModel();
        $employeeModel   = new EmployeeModel();
        $departmentModel = new DepartmentModel();

        $shifts      = $shiftModel->getShiftsWithAllocationStats();
        $departments = $departmentModel->findAll();
        $employees   = $employeeModel->whereIn('employment_status', ['active', 'probation', 'notice_period'])->where('deleted_at', null)->findAll();

        $filters = [
            'department_id' => $this->request->getGet('department_id'),
            'shift_id'      => $this->request->getGet('shift_id'),
            'status'        => $this->request->getGet('status') ?: 'active',
        ];

        $allocations = $allocationModel->getDetailedAllocations(array_filter($filters), 50);

        $data = [
            'shifts'      => $shifts,
            'allocations' => $allocations,
            'departments' => $departments,
            'employees'   => $employees,
            'filters'     => $filters,
        ];

        return $this->render('shifts/index', $data, 'Shift and Rotation');
    }

    /**
     * Store new Shift Definition
     */
    public function store()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized access to create shifts.');
            return redirect()->to(site_url('shifts'));
        }

        $rules = [
            'name'                 => 'required|min_length[3]|max_length[60]',
            'code'                 => 'required|min_length[2]|max_length[20]|is_unique[shifts.code]',
            'shift_type'           => 'required|in_list[regular,rotational,split,night,flexible]',
            'start_time'           => 'required',
            'end_time'             => 'required',
            'break_duration_mins'  => 'required|numeric',
            'late_grace_mins'      => 'required|numeric',
            'early_exit_grace_mins'=> 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('shifts'));
        }

        $shiftModel = new ShiftModel();
        $shiftModel->insert([
            'company_id'            => 1,
            'name'                  => $this->request->getPost('name'),
            'code'                  => strtoupper($this->request->getPost('code')),
            'shift_type'            => $this->request->getPost('shift_type'),
            'start_time'            => $this->request->getPost('start_time'),
            'end_time'              => $this->request->getPost('end_time'),
            'break_duration_mins'   => (int)$this->request->getPost('break_duration_mins'),
            'late_grace_mins'       => (int)$this->request->getPost('late_grace_mins'),
            'early_exit_grace_mins' => (int)$this->request->getPost('early_exit_grace_mins'),
            'half_day_hours'        => (float)($this->request->getPost('half_day_hours') ?: 4.50),
            'full_day_hours'        => (float)($this->request->getPost('full_day_hours') ?: 8.00),
            'overtime_eligible'     => $this->request->getPost('overtime_eligible') ? 1 : 0,
            'min_overtime_mins'     => (int)($this->request->getPost('min_overtime_mins') ?: 30),
            'is_night_shift'        => $this->request->getPost('is_night_shift') ? 1 : 0,
            'status'                => 'active',
        ]);

        $this->logAudit('SHIFT_CREATE', 'shifts', "Created shift {$this->request->getPost('name')}");
        $this->session->setFlashdata('success', 'Shift created successfully.');
        return redirect()->to(site_url('shifts'));
    }

    /**
     * Update Shift Definition
     */
    public function update($id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized access to edit shifts.');
            return redirect()->to(site_url('shifts'));
        }

        $shiftModel = new ShiftModel();
        $shift = $shiftModel->find((int)$id);
        if (!$shift) {
            $this->session->setFlashdata('error', 'Shift not found.');
            return redirect()->to(site_url('shifts'));
        }

        $rules = [
            'name'                  => 'required|min_length[3]|max_length[60]',
            'code'                  => "required|min_length[2]|max_length[20]|is_unique[shifts.code,id,{$id}]",
            'shift_type'            => 'required|in_list[regular,rotational,split,night,flexible]',
            'start_time'            => 'required',
            'end_time'              => 'required',
            'break_duration_mins'   => 'required|numeric',
            'late_grace_mins'       => 'required|numeric',
            'early_exit_grace_mins' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('shifts'));
        }

        $shiftModel->update((int)$id, [
            'name'                  => $this->request->getPost('name'),
            'code'                  => strtoupper($this->request->getPost('code')),
            'shift_type'            => $this->request->getPost('shift_type'),
            'start_time'            => $this->request->getPost('start_time'),
            'end_time'              => $this->request->getPost('end_time'),
            'break_duration_mins'   => (int)$this->request->getPost('break_duration_mins'),
            'late_grace_mins'       => (int)$this->request->getPost('late_grace_mins'),
            'early_exit_grace_mins' => (int)$this->request->getPost('early_exit_grace_mins'),
            'half_day_hours'        => (float)($this->request->getPost('half_day_hours') ?: 4.50),
            'full_day_hours'        => (float)($this->request->getPost('full_day_hours') ?: 8.00),
            'overtime_eligible'     => $this->request->getPost('overtime_eligible') ? 1 : 0,
            'min_overtime_mins'     => (int)($this->request->getPost('min_overtime_mins') ?: 30),
            'is_night_shift'        => $this->request->getPost('is_night_shift') ? 1 : 0,
            'status'                => $this->request->getPost('status') ?: 'active',
        ]);

        $this->logAudit('SHIFT_UPDATE', 'shifts', "Updated shift {$this->request->getPost('name')} (ID: {$id})");
        $this->session->setFlashdata('success', "Shift '{$this->request->getPost('name')}' updated successfully.");
        return redirect()->to(site_url('shifts'));
    }

    /**
     * Delete Shift Definition
     */
    public function delete($id)
    {
        if (($this->currentUser['role_slug'] ?? '') !== 'super_admin') {
            $this->session->setFlashdata('error', 'Access Denied: Only Super Admin is authorized to delete shifts.');
            return redirect()->to(site_url('shifts'));
        }

        $shiftModel = new ShiftModel();
        $shift = $shiftModel->find((int)$id);
        if (!$shift) {
            $this->session->setFlashdata('error', 'Shift not found.');
            return redirect()->to(site_url('shifts'));
        }

        $shiftName = $shift['name'];
        $shiftModel->delete((int)$id);

        $this->logAudit('SHIFT_DELETE', 'shifts', "Deleted shift {$shiftName} (ID: {$id})");
        $this->session->setFlashdata('success', "Shift '{$shiftName}' deleted successfully.");
        return redirect()->to(site_url('shifts'));
    }

    /**
     * Delete / Remove Shift Allocation
     */
    public function deallocate($id)
    {
        if (($this->currentUser['role_slug'] ?? '') !== 'super_admin') {
            $this->session->setFlashdata('error', 'Access Denied: Only Super Admin is authorized to remove shift allocations.');
            return redirect()->to(site_url('shifts'));
        }

        $allocModel = new ShiftAllocationModel();
        $alloc = $allocModel->find((int)$id);
        if (!$alloc) {
            $this->session->setFlashdata('error', 'Shift assignment record not found.');
            return redirect()->to(site_url('shifts'));
        }

        $allocModel->delete((int)$id);

        $this->logAudit('SHIFT_DEALLOCATE', 'shifts', "Removed shift assignment ID {$id}");
        $this->session->setFlashdata('success', 'Employee shift assignment removed successfully.');
        return redirect()->to(site_url('shifts'));
    }

    /**
     * Allocate Employee to Shift
     */
    public function allocate()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to assign shifts.');
            return redirect()->to(site_url('shifts'));
        }

        $employeeId      = (int)$this->request->getPost('employee_id');
        $shiftId         = (int)$this->request->getPost('shift_id');
        $fromDate        = $this->request->getPost('from_date');
        $toDate          = $this->request->getPost('to_date') ?: null;
        $rotationPattern = $this->request->getPost('rotation_pattern') ?: 'fixed';

        if (!$employeeId || !$shiftId || !$fromDate) {
            $this->session->setFlashdata('error', 'Employee, Shift, and Effective Start Date are mandatory.');
            return redirect()->to(site_url('shifts'));
        }

        $allocationModel = new ShiftAllocationModel();

        // Deactivate previous open-ended active allocations
        $allocationModel->where('employee_id', $employeeId)
            ->where('status', 'active')
            ->where('to_date', null)
            ->set(['to_date' => date('Y-m-d', strtotime($fromDate . ' -1 day')), 'status' => 'transferred'])
            ->update();

        $allocationModel->insert([
            'employee_id'      => $employeeId,
            'shift_id'         => $shiftId,
            'from_date'        => $fromDate,
            'to_date'          => $toDate,
            'rotation_pattern' => $rotationPattern,
            'assigned_by'      => $this->userId(),
            'status'           => 'active',
            'notes'            => $this->request->getPost('notes'),
        ]);

        $this->logAudit('SHIFT_ALLOCATE', 'shifts', "Assigned Shift ID {$shiftId} to Employee ID {$employeeId}");
        $this->session->setFlashdata('success', 'Employee shift assigned successfully.');
        return redirect()->to(site_url('shifts'));
    }

    /**
     * Shift Roster & Calendar Matrix View
     */
    public function roster()
    {
        $departmentModel = new DepartmentModel();
        $shiftModel      = new ShiftModel();
        $allocationModel = new ShiftAllocationModel();

        $departments  = $departmentModel->findAll();
        $shifts       = $shiftModel->findAll();
        $selectedDept = $this->request->getGet('department_id');
        if ($selectedDept === null || $selectedDept === '') {
            $selectedDept = 'all';
        }
        $rawStart = $this->request->getGet('start_date');
        $rawEnd   = $this->request->getGet('end_date');

        if (!$rawStart || !strtotime($rawStart)) {
            $startDate = date('Y-m-01');
        } else {
            $startDate = date('Y-m-d', strtotime($rawStart));
        }

        if (!$rawEnd || !strtotime($rawEnd)) {
            $endDate = date('Y-m-t', strtotime($startDate));
        } else {
            $endDate = date('Y-m-d', strtotime($rawEnd));
        }

        if ($startDate > $endDate) {
            $endDate = date('Y-m-t', strtotime($startDate));
        }

        $diffDays = (strtotime($endDate) - strtotime($startDate)) / 86400;
        if ($diffDays > 45) {
            $endDate = date('Y-m-d', strtotime($startDate . ' + 44 days'));
        }

        $empModel = new EmployeeModel();
        $empBuilder = $empModel->select('employees.*, d.name as department_name')
            ->join('departments d', 'd.id = employees.department_id', 'left')
            ->where('employees.employment_status', 'active');

        if ($selectedDept !== 'all') {
            $empBuilder->where('employees.department_id', (int)$selectedDept);
        }

        $team = $empBuilder->orderBy('employees.first_name', 'ASC')->findAll();

        $allocations = $allocationModel->select('shift_allocations.*, s.code as shift_code')
            ->join('shifts s', 's.id = shift_allocations.shift_id')
            ->where('shift_allocations.status', 'active')
            ->findAll();

        $empShiftMap = [];
        foreach ($allocations as $al) {
            $empShiftMap[$al['employee_id']][] = $al;
        }

        $data = [
            'departments'  => $departments,
            'shifts'       => $shifts,
            'selectedDept' => $selectedDept,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'team'         => $team,
            'empShiftMap'  => $empShiftMap,
        ];

        return $this->render('shifts/roster', $data, 'Shift Roster & Rotation Planner');
    }
}
