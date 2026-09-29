<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\BranchModel;
use App\Models\UserModel;
use App\Models\RoleModel;

class EmployeeController extends BaseController
{
    /**
     * List all employees with filters and search
     */
    public function index()
    {
        if (!$this->hasPermission('employee.view')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view employee directory.');
            return redirect()->to(site_url('dashboard'));
        }

        $employeeModel   = new EmployeeModel();
        $departmentModel = new DepartmentModel();
        $branchModel     = new BranchModel();

        $search           = $this->request->getGet('search');
        $departmentId     = $this->request->getGet('department_id');
        $branchId         = $this->request->getGet('branch_id');
        $employmentStatus = $this->request->getGet('employment_status');

        $filters = array_filter([
            'search'            => $search,
            'department_id'     => $departmentId,
            'branch_id'         => $branchId,
            'employment_status' => $employmentStatus,
        ]);

        $employees   = $employeeModel->getDetailedList($filters, 50, 0);
        $departments = $departmentModel->findAll();
        $branches    = $branchModel->findAll();

        $data = [
            'employees'   => $employees,
            'departments' => $departments,
            'branches'    => $branches,
            'filters'     => [
                'search'            => $search,
                'department_id'     => $departmentId,
                'branch_id'         => $branchId,
                'employment_status' => $employmentStatus,
            ],
            'totalCount'  => count($employees),
        ];

        return $this->render('employees/index', $data, 'Employee Master Directory');
    }

    /**
     * Display Unified Employee 360° Profile
     */
    public function view(int $id)
    {
        $isOwn = !empty($this->currentUser['employee_id']) && ((int)$this->currentUser['employee_id'] === $id);
        if (!$this->hasPermission('employee.view') && !$isOwn) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view employee profiles.');
            return redirect()->to(site_url('dashboard'));
        }

        $employeeModel = new EmployeeModel();
        $employee = $employeeModel->get360Profile($id);

        if (!$employee) {
            $this->session->setFlashdata('error', 'The requested employee profile was not found.');
            return redirect()->to(site_url('employees'));
        }

        $data = [
            'employee' => $employee,
        ];

        return $this->render('employees/view', $data, "360° Profile: {$employee['first_name']} {$employee['last_name']} ({$employee['employee_code']})");
    }

    /**
     * Show form to add a new employee
     */
    public function create()
    {
        // Enforce RBAC: employee.create capability required
        if (!$this->hasPermission('employee.create')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to onboard new employees.');
            return redirect()->to(site_url('employees'));
        }

        $employeeModel   = new EmployeeModel();
        $departmentModel = new DepartmentModel();
        $designationModel= new DesignationModel();
        $branchModel     = new BranchModel();
        $roleModel       = new RoleModel();

        $db = \Config\Database::connect();
        $payGrades = $db->table('pay_grades')->orderBy('id', 'ASC')->get()->getResultArray();
        $managers  = $employeeModel->select('id, first_name, last_name, employee_code')->findAll();

        $data = [
            'nextCode'     => $employeeModel->generateEmployeeCode(),
            'departments'  => $departmentModel->findAll(),
            'designations' => $designationModel->findAll(),
            'branches'     => $branchModel->findAll(),
            'payGrades'    => $payGrades,
            'roles'        => $roleModel->orderBy('hierarchy_level', 'ASC')->orderBy('id', 'ASC')->findAll(),
            'managers'     => $managers,
        ];

        return $this->render('employees/create', $data, 'Onboard New Employee');
    }

    /**
     * Process employee creation submission
     */
    public function store()
    {
        // Enforce RBAC: employee.create capability required
        if (!$this->hasPermission('employee.create')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to onboard new employees.');
            return redirect()->to(site_url('employees'));
        }

        $employeeModel = new EmployeeModel();
        $userModel     = new UserModel();
        $db            = \Config\Database::connect();

        $code = trim((string)$this->request->getPost('employee_code'));
        if (empty($code)) {
            $code = $employeeModel->generateEmployeeCode();
        } else {
            // Check if submitted code already exists
            $existingWithCode = $employeeModel->where('employee_code', $code)->withDeleted()->first();
            if ($existingWithCode) {
                $code = $employeeModel->generateEmployeeCode();
            }
        }

        $email = trim((string)$this->request->getPost('email'));
        $firstName = trim((string)$this->request->getPost('first_name'));
        $lastName = trim((string)$this->request->getPost('last_name'));

        // Basic validation
        if (empty($firstName) || empty($lastName) || empty($email)) {
            $this->session->setFlashdata('error', 'First name, last name, and primary email are required.');
            return redirect()->back()->withInput();
        }

        // Check unique email in employees
        $existingEmp = $employeeModel->where('email', $email)->withDeleted()->first();
        if ($existingEmp) {
            $this->session->setFlashdata('error', "An employee record with email '{$email}' already exists.");
            return redirect()->back()->withInput();
        }

        // Check unique email in users
        $existingUser = $userModel->where('email', $email)->withDeleted()->first();
        if ($existingUser) {
            $this->session->setFlashdata('error', "A portal user account with email '{$email}' already exists.");
            return redirect()->back()->withInput();
        }

        try {
            $db->transStart();

            // Handle Profile Photo Upload
            $profilePhotoPath = null;
            $photoFile = $this->request->getFile('profile_photo');
            if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                $uploadDir = FCPATH . 'uploads/avatars';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $photoName = $photoFile->getRandomName();
                $photoFile->move($uploadDir, $photoName);
                $profilePhotoPath = 'uploads/avatars/' . $photoName;
            }

            $empType   = $this->request->getPost('employment_type') ?: 'full_time';
            $empStatus = ($empType === 'probation') ? 'probation' : ($this->request->getPost('employment_status') ?: 'active');
            $joiningDate = $this->request->getPost('joining_date') ?: date('Y-m-d');
            $probEndDate = null;
            if ($empType === 'probation' || $empStatus === 'probation') {
                $probMonths = (int)($this->request->getPost('probation_duration_months') ?: 3);
                $probEndDate = date('Y-m-d', strtotime("+{$probMonths} months", strtotime($joiningDate)));
            }

            // 1. Insert Employee Master Profile
            $empData = [
                'company_id'         => 1,
                'branch_id'          => $this->request->getPost('branch_id') ?: null,
                'department_id'      => $this->request->getPost('department_id') ?: null,
                'designation_id'     => $this->request->getPost('designation_id') ?: null,
                'pay_grade_id'       => $this->request->getPost('pay_grade_id') ?: null,
                'employee_code'      => $code,
                'first_name'         => $firstName,
                'middle_name'        => trim((string)$this->request->getPost('middle_name')),
                'last_name'          => $lastName,
                'email'              => $email,
                'official_email'     => trim((string)$this->request->getPost('official_email')) ?: $email,
                'phone'              => trim((string)$this->request->getPost('phone')),
                'gender'             => $this->request->getPost('gender') ?: 'male',
                'date_of_birth'      => $this->request->getPost('date_of_birth') ?: null,
                'marital_status'     => $this->request->getPost('marital_status') ?: 'single',
                'blood_group'        => trim((string)$this->request->getPost('blood_group')),
                'joining_date'       => $joiningDate,
                'employment_type'    => $empType,
                'employment_status'  => $empStatus,
                'probation_end_date' => $probEndDate,
                'reporting_to'       => $this->request->getPost('reporting_to') ?: null,
                'present_address'    => trim((string)$this->request->getPost('present_address')),
                'permanent_address'  => trim((string)$this->request->getPost('permanent_address')),
                'city'               => trim((string)$this->request->getPost('city')),
                'state'              => trim((string)$this->request->getPost('state')),
                'country'            => trim((string)$this->request->getPost('country')) ?: 'United States',
                'postal_code'        => trim((string)$this->request->getPost('postal_code')),
                'emergency_contact_name'  => trim((string)$this->request->getPost('emergency_contact_name')),
                'emergency_contact_phone' => trim((string)$this->request->getPost('emergency_contact_phone')),
                'profile_photo'      => $profilePhotoPath,
            ];

            $employeeId = $employeeModel->insert($empData);
            if (!$employeeId) {
                $db->transRollback();
                $err = implode(' ', $employeeModel->errors() ?: ['Failed to save employee profile.']);
                $this->session->setFlashdata('error', $err);
                return redirect()->back()->withInput();
            }

            $employeeId = (int)$employeeId;

            // Auto-enroll in probation tracking if applicable
            if ($empType === 'probation' || $empStatus === 'probation') {
                $probationModel = new \App\Models\ProbationAssessmentModel();
                $isDue = (strtotime($probEndDate) <= strtotime('+15 days'));
                $probationModel->insert([
                    'employee_id'                => $employeeId,
                    'joining_date'               => $joiningDate,
                    'initial_probation_end_date' => $probEndDate,
                    'current_probation_end_date' => $probEndDate,
                    'assessment_status'          => $isDue ? 'due' : 'under_review',
                    'manager_id'                 => $empData['reporting_to'],
                ]);
            }

            // 2. Create User Account with Role and Password
            $customUsername = trim((string)$this->request->getPost('username'));
            if (!empty($customUsername)) {
                $username = strtolower(preg_replace('/[^a-zA-Z0-9._-]/', '', $customUsername));
            } else {
                $username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName . '.' . $lastName));
            }
            if (strlen($username) < 3) {
                $username = $username . rand(100, 999);
            }

            // Ensure unique username
            $candidateUsername = $username;
            $counter = 1;
            while ($userModel->where('username', $candidateUsername)->withDeleted()->first()) {
                $candidateUsername = $username . rand(10, 99);
                $counter++;
                if ($counter > 25) {
                    $candidateUsername = $username . time();
                    break;
                }
            }
            $username = $candidateUsername;

            $roleId = (int)($this->request->getPost('role_id') ?: 7); // Default to Employee (Role 7)

            // Custom password or default
            $inputPassword = trim((string)$this->request->getPost('password'));
            $plainPassword = !empty($inputPassword) ? $inputPassword : 'Admin@123';
            $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

            $userId = $userModel->insert([
                'employee_id'   => $employeeId,
                'username'      => $username,
                'email'         => $email,
                'password_hash' => $passwordHash,
                'role_id'       => $roleId,
                'status'        => 'active',
            ]);

            if ($userId) {
                $employeeModel->update($employeeId, ['user_id' => (int)$userId]);
            }

            // 3. Process Onboarding Documents Uploads (Vault)
            $docUploadDir = FCPATH . 'uploads/documents';
            if (!is_dir($docUploadDir)) {
                mkdir($docUploadDir, 0777, true);
            }

            // A. Standard common document slots
            $standardDocs = [
                'doc_resume' => [
                    'type'   => 'resume',
                    'title'  => trim((string)$this->request->getPost('doc_resume_title')) ?: 'Resume / Curriculum Vitae',
                    'expiry' => null,
                ],
                'doc_national_id' => [
                    'type'   => $this->request->getPost('doc_national_id_type') ?: 'national_id',
                    'title'  => trim((string)$this->request->getPost('doc_national_id_title')) ?: 'Government ID Proof',
                    'expiry' => $this->request->getPost('doc_national_id_expiry') ?: null,
                ],
                'doc_contract' => [
                    'type'   => 'contract',
                    'title'  => trim((string)$this->request->getPost('doc_contract_title')) ?: 'Signed Employment Agreement',
                    'expiry' => null,
                ],
                'doc_degree' => [
                    'type'   => 'degree',
                    'title'  => trim((string)$this->request->getPost('doc_degree_title')) ?: 'Degree / Qualification Certificate',
                    'expiry' => null,
                ],
            ];

            foreach ($standardDocs as $inputName => $meta) {
                $docFile = $this->request->getFile($inputName);
                if ($docFile && $docFile->isValid() && !$docFile->hasMoved()) {
                    $docName = $docFile->getRandomName();
                    $docFile->move($docUploadDir, $docName);
                    $db->table('employee_documents')->insert([
                        'employee_id'    => $employeeId,
                        'document_type'  => $meta['type'],
                        'document_title' => $meta['title'],
                        'file_path'      => 'uploads/documents/' . $docName,
                        'file_size'      => (int)$docFile->getSize(),
                        'expiry_date'    => !empty($meta['expiry']) ? $meta['expiry'] : null,
                        'is_verified'    => 1,
                        'verified_by'    => $this->userId(),
                        'uploaded_at'    => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            // B. Dynamic / Additional Custom Documents
            $customDocFiles = $this->request->getFileMultiple('custom_docs');
            $customTitles   = (array)$this->request->getPost('custom_doc_titles');
            $customTypes    = (array)$this->request->getPost('custom_doc_types');
            $customExpiries = (array)$this->request->getPost('custom_doc_expiries');

            if (!empty($customDocFiles)) {
                foreach ($customDocFiles as $idx => $cFile) {
                    if ($cFile && $cFile->isValid() && !$cFile->hasMoved()) {
                        $cTitle  = !empty($customTitles[$idx]) ? trim($customTitles[$idx]) : ('Document ' . ($idx + 1));
                        $cType   = !empty($customTypes[$idx]) ? $customTypes[$idx] : 'other';
                        $cExpiry = !empty($customExpiries[$idx]) ? $customExpiries[$idx] : null;
                        $cName   = $cFile->getRandomName();
                        $cFile->move($docUploadDir, $cName);
                        $db->table('employee_documents')->insert([
                            'employee_id'    => $employeeId,
                            'document_type'  => $cType,
                            'document_title' => $cTitle,
                            'file_path'      => 'uploads/documents/' . $cName,
                            'file_size'      => (int)$cFile->getSize(),
                            'expiry_date'    => $cExpiry,
                            'is_verified'    => 1,
                            'verified_by'    => $this->userId(),
                            'uploaded_at'    => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }

            // 4. Bank Details if supplied
            $bankName = trim((string)$this->request->getPost('bank_name'));
            $accountNumber = trim((string)$this->request->getPost('account_number'));
            if (!empty($bankName) && !empty($accountNumber)) {
                $db->table('employee_bank_details')->insert([
                    'employee_id'    => $employeeId,
                    'bank_name'      => $bankName,
                    'account_name'   => trim((string)$this->request->getPost('account_name')) ?: "{$firstName} {$lastName}",
                    'account_number' => $accountNumber,
                    'ifsc_swift_code'=> trim((string)$this->request->getPost('ifsc_swift_code')),
                    'payment_method' => 'bank_transfer',
                    'is_primary'     => 1,
                ]);
            }

            // 5. Default Leave Balances for Current Year
            $currentYear = date('Y');
            $leaveTypes = $db->table('leave_types')->where('status', 'active')->get()->getResultArray();
            foreach ($leaveTypes as $lt) {
                $db->table('leave_balances')->insert([
                    'employee_id'    => $employeeId,
                    'leave_type_id'  => $lt['id'],
                    'year'           => $currentYear,
                    'allocated_days' => $lt['days_allowed_per_year'],
                    'used_days'      => 0.0,
                    'pending_days'   => 0.0,
                    'remaining_days' => $lt['days_allowed_per_year'],
                ]);
            }

            // 6. Salary Structure & Manual Compensation Setup
            $basicSalaryInput = $this->request->getPost('basic_salary');
            if ($basicSalaryInput !== null && $basicSalaryInput !== '') {
                $basicSalary = (float)$basicSalaryInput;
                $salaryMode  = $this->request->getPost('salary_mode') ?: 'auto';
                
                if ($salaryMode === 'auto') {
                    $hra   = round($basicSalary * 0.40, 2);
                    $conv  = 1600.00;
                    $spec  = round($basicSalary * 0.10, 2);
                    $med   = 1250.00;
                    $other = 0.00;
                    $pf    = round($basicSalary * 0.12, 2);
                    $tax   = round($basicSalary * 0.10, 2);
                    $ins   = 120.00;
                } else {
                    $hra   = (float)$this->request->getPost('hra');
                    $conv  = (float)$this->request->getPost('conveyance_allowance');
                    $spec  = (float)$this->request->getPost('special_allowance');
                    $med   = (float)$this->request->getPost('medical_allowance');
                    $other = (float)$this->request->getPost('other_allowances');
                    $pf    = (float)$this->request->getPost('pf_deduction');
                    $tax   = (float)$this->request->getPost('tax_deduction');
                    $ins   = (float)($this->request->getPost('insurance_deduction') ?: 120.00);
                }

                $gross = $basicSalary + $hra + $conv + $spec + $med + $other;
                $totalDeductions = $pf + $tax + $ins;
                $net = max(0, $gross - $totalDeductions);

                $db->table('salary_structures')->insert([
                    'employee_id'          => $employeeId,
                    'effective_date'       => $this->request->getPost('joining_date') ?: date('Y-m-d'),
                    'basic_salary'         => $basicSalary,
                    'hra'                  => $hra,
                    'conveyance_allowance' => $conv,
                    'special_allowance'    => $spec,
                    'medical_allowance'    => $med,
                    'other_allowances'     => $other,
                    'gross_salary'         => $gross,
                    'pf_deduction'         => $pf,
                    'tax_deduction'        => $tax,
                    'insurance_deduction'  => $ins,
                    'total_deductions'     => $totalDeductions,
                    'net_salary'           => $net,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Database transaction failed during onboarding.');
            }

            $roleObj = $db->table('roles')->where('id', $roleId)->get()->getFirstRow('array');
            $roleName = $roleObj ? $roleObj['name'] : 'Employee';

            $this->logAudit('CREATE_EMPLOYEE', 'employee', "Onboarded employee {$firstName} {$lastName} ({$code}) with role '{$roleName}' and user account '{$username}'.", $employeeId);

            $this->session->setFlashdata('success', "Employee {$firstName} {$lastName} ({$code}) onboarded successfully with role <strong>{$roleName}</strong>! Portal Login &mdash; Username: <code>{$username}</code>, Password: <code>" . esc($plainPassword) . "</code>.");
            return redirect()->to(site_url('employees/view/' . $employeeId));

        } catch (\Throwable $e) {
            $db->transRollback();
            $this->session->setFlashdata('error', 'Error onboarding employee: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show form to edit existing employee
     */
    public function edit(int $id)
    {
        // Enforce RBAC: employee.edit capability required
        if (!$this->hasPermission('employee.edit')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to edit employee profiles.');
            return redirect()->to(site_url('employees/view/' . $id));
        }

        $employeeModel   = new EmployeeModel();
        $departmentModel = new DepartmentModel();
        $designationModel= new DesignationModel();
        $branchModel     = new BranchModel();
        $roleModel       = new RoleModel();

        $employee = $employeeModel->find($id);
        if (!$employee) {
            $this->session->setFlashdata('error', 'Employee not found.');
            return redirect()->to(site_url('employees'));
        }

        $db = \Config\Database::connect();
        $payGrades = $db->table('pay_grades')->orderBy('id', 'ASC')->get()->getResultArray();
        $managers  = $employeeModel->select('id, first_name, last_name, employee_code')
            ->where('id !=', $id)
            ->findAll();

        $user = $db->table('users')->where('employee_id', $id)->get()->getFirstRow('array');
        $salaryStructure = $db->table('salary_structures')
            ->where('employee_id', $id)
            ->orderBy('effective_date', 'DESC')
            ->get()
            ->getFirstRow('array');

        $data = [
            'employee'        => $employee,
            'user'            => $user,
            'salaryStructure' => $salaryStructure,
            'departments'     => $departmentModel->findAll(),
            'designations'    => $designationModel->findAll(),
            'branches'        => $branchModel->findAll(),
            'payGrades'       => $payGrades,
            'roles'           => $roleModel->orderBy('hierarchy_level', 'ASC')->orderBy('id', 'ASC')->findAll(),
            'managers'        => $managers,
        ];

        return $this->render('employees/edit', $data, "Edit Employee: {$employee['first_name']} {$employee['last_name']}");
    }

    /**
     * Process employee profile update
     */
    public function update(int $id)
    {
        // Enforce RBAC: employee.edit capability required
        if (!$this->hasPermission('employee.edit')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to update employee profiles.');
            return redirect()->to(site_url('employees/view/' . $id));
        }

        $employeeModel = new EmployeeModel();
        $userModel     = new UserModel();
        $employee      = $employeeModel->find($id);

        if (!$employee) {
            $this->session->setFlashdata('error', 'Employee not found.');
            return redirect()->to(site_url('employees'));
        }

        $firstName = trim((string)$this->request->getPost('first_name'));
        $lastName  = trim((string)$this->request->getPost('last_name'));
        $email     = trim((string)$this->request->getPost('email'));

        if (empty($firstName) || empty($lastName) || empty($email)) {
            $this->session->setFlashdata('error', 'First name, last name, and email are required.');
            return redirect()->back()->withInput();
        }

        $empStatus = $this->request->getPost('employment_status') ?: $employee['employment_status'];

        $updateData = [
            'first_name'         => $firstName,
            'middle_name'        => trim((string)$this->request->getPost('middle_name')),
            'last_name'          => $lastName,
            'email'              => $email,
            'official_email'     => trim((string)$this->request->getPost('official_email')) ?: $email,
            'phone'              => trim((string)$this->request->getPost('phone')),
            'gender'             => $this->request->getPost('gender') ?: $employee['gender'],
            'date_of_birth'      => $this->request->getPost('date_of_birth') ?: null,
            'marital_status'     => $this->request->getPost('marital_status') ?: $employee['marital_status'],
            'blood_group'        => trim((string)$this->request->getPost('blood_group')),
            'branch_id'          => $this->request->getPost('branch_id') ?: null,
            'department_id'      => $this->request->getPost('department_id') ?: null,
            'designation_id'     => $this->request->getPost('designation_id') ?: null,
            'pay_grade_id'       => $this->request->getPost('pay_grade_id') ?: null,
            'reporting_to'       => $this->request->getPost('reporting_to') ?: null,
            'employment_type'    => $this->request->getPost('employment_type') ?: $employee['employment_type'],
            'employment_status'  => $empStatus,
            'present_address'    => trim((string)$this->request->getPost('present_address')),
            'permanent_address'  => trim((string)$this->request->getPost('permanent_address')),
            'city'               => trim((string)$this->request->getPost('city')),
            'state'              => trim((string)$this->request->getPost('state')),
            'country'            => trim((string)$this->request->getPost('country')) ?: ($employee['country'] ?? 'United States'),
            'postal_code'        => trim((string)$this->request->getPost('postal_code')),
            'emergency_contact_name'  => trim((string)$this->request->getPost('emergency_contact_name')),
            'emergency_contact_relation' => trim((string)$this->request->getPost('emergency_contact_relation')),
            'emergency_contact_phone' => trim((string)$this->request->getPost('emergency_contact_phone')),
        ];

        // Handle Profile Photo Upload on Update
        $photoFile = $this->request->getFile('profile_photo');
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/avatars';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photoName = $photoFile->getRandomName();
            $photoFile->move($uploadDir, $photoName);
            $updateData['profile_photo'] = 'uploads/avatars/' . $photoName;
        }

        $employeeModel->update($id, $updateData);

        // Sync user role, password, and status if linked
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('employee_id', $id)->get()->getFirstRow('array');
        $passwordChanged = false;
        $roleChanged = false;
        $newRoleName = '';
        $newPlainPassword = '';

        if ($user) {
            $userUpdate = [];
            $roleId = $this->request->getPost('role_id');
            if ($roleId && (int)$roleId !== (int)$user['role_id']) {
                $userUpdate['role_id'] = (int)$roleId;
                $roleChanged = true;
                $rObj = $db->table('roles')->where('id', (int)$roleId)->get()->getFirstRow('array');
                if ($rObj) $newRoleName = $rObj['name'];
            }
            if ($empStatus === 'terminated' || $empStatus === 'resigned') {
                $userUpdate['status'] = 'inactive';
            } elseif ($empStatus === 'active') {
                $userUpdate['status'] = 'active';
            }

            // Set new password if provided
            $newPassword = trim((string)$this->request->getPost('password'));
            if (!empty($newPassword)) {
                $userUpdate['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
                $passwordChanged = true;
                $newPlainPassword = $newPassword;
            }

            // Update username if custom provided
            $customUsername = trim((string)$this->request->getPost('username'));
            if (!empty($customUsername) && $customUsername !== $user['username']) {
                $sanitizedUsername = strtolower(preg_replace('/[^a-zA-Z0-9._-]/', '', $customUsername));
                if (strlen($sanitizedUsername) >= 3) {
                    $existing = $userModel->where('username', $sanitizedUsername)->where('id !=', $user['id'])->first();
                    if (!$existing) {
                        $userUpdate['username'] = $sanitizedUsername;
                    }
                }
            }

            if (!empty($userUpdate)) {
                $userModel->update($user['id'], $userUpdate);
            }
        } elseif ($this->request->getPost('role_id')) {
            // Provision user account if one didn't exist
            $roleId = (int)$this->request->getPost('role_id');
            $customUsername = trim((string)$this->request->getPost('username')) ?: strtolower($firstName . '.' . $lastName);
            $sanitizedUsername = strtolower(preg_replace('/[^a-zA-Z0-9._-]/', '', $customUsername));
            if (strlen($sanitizedUsername) < 3) $sanitizedUsername = 'emp' . $id;
            if ($userModel->where('username', $sanitizedUsername)->first()) {
                $sanitizedUsername .= rand(10, 99);
            }
            $newPassword = trim((string)$this->request->getPost('password')) ?: 'Admin@123';
            $userId = $userModel->insert([
                'employee_id'   => $id,
                'username'      => $sanitizedUsername,
                'email'         => $employee['email'],
                'password_hash' => password_hash($newPassword, PASSWORD_BCRYPT),
                'role_id'       => $roleId,
                'status'        => 'active',
            ]);
            $employeeModel->update($id, ['user_id' => $userId]);
            $passwordChanged = true;
            $newPlainPassword = $newPassword;
        }

        // Update or insert Salary Structure if basic_salary was provided
        $basicSalaryInput = $this->request->getPost('basic_salary');
        if ($basicSalaryInput !== null && $basicSalaryInput !== '') {
            $basicSalary = (float)$basicSalaryInput;
            $salaryMode  = $this->request->getPost('salary_mode') ?: 'auto';

            if ($salaryMode === 'auto') {
                $hra   = round($basicSalary * 0.40, 2);
                $conv  = 1600.00;
                $spec  = round($basicSalary * 0.10, 2);
                $med   = 1250.00;
                $other = 0.00;
                $pf    = round($basicSalary * 0.12, 2);
                $tax   = round($basicSalary * 0.10, 2);
                $ins   = 120.00;
            } else {
                $hra   = (float)$this->request->getPost('hra');
                $conv  = (float)$this->request->getPost('conveyance_allowance');
                $spec  = (float)$this->request->getPost('special_allowance');
                $med   = (float)$this->request->getPost('medical_allowance');
                $other = (float)$this->request->getPost('other_allowances');
                $pf    = (float)$this->request->getPost('pf_deduction');
                $tax   = (float)$this->request->getPost('tax_deduction');
                $ins   = (float)($this->request->getPost('insurance_deduction') ?: 120.00);
            }

            $gross = $basicSalary + $hra + $conv + $spec + $med + $other;
            $totalDeductions = $pf + $tax + $ins;
            $net = max(0, $gross - $totalDeductions);

            $existingSalary = $db->table('salary_structures')->where('employee_id', $id)->get()->getFirstRow('array');
            $salaryData = [
                'basic_salary'         => $basicSalary,
                'hra'                  => $hra,
                'conveyance_allowance' => $conv,
                'special_allowance'    => $spec,
                'medical_allowance'    => $med,
                'other_allowances'     => $other,
                'gross_salary'         => $gross,
                'pf_deduction'         => $pf,
                'tax_deduction'        => $tax,
                'insurance_deduction'  => $ins,
                'total_deductions'     => $totalDeductions,
                'net_salary'           => $net,
            ];

            if ($existingSalary) {
                $db->table('salary_structures')->where('id', $existingSalary['id'])->update($salaryData);
            } else {
                $salaryData['employee_id'] = $id;
                $salaryData['effective_date'] = $employee['joining_date'] ?: date('Y-m-d');
                $db->table('salary_structures')->insert($salaryData);
            }
        }

        $auditMsg = "Updated employee details for {$firstName} {$lastName} ({$employee['employee_code']}).";
        if ($roleChanged) $auditMsg .= " Role changed to {$newRoleName}.";
        if ($passwordChanged) $auditMsg .= " Portal password updated.";
        $this->logAudit('UPDATE_EMPLOYEE', 'employee', $auditMsg, $id);

        $flashMsg = "Employee profile for {$firstName} {$lastName} updated successfully.";
        if ($roleChanged && !empty($newRoleName)) {
            $flashMsg .= " System role set to <strong>{$newRoleName}</strong>.";
        }
        if ($passwordChanged) {
            $flashMsg .= " Portal password has been updated to <code>" . esc($newPlainPassword) . "</code>.";
        }
        $this->session->setFlashdata('success', $flashMsg);
        return redirect()->to(site_url('employees/view/' . $id));
    }

    /**
     * Upload and catalog document in employee vault
     */
    public function uploadDocument()
    {
        $employeeId = (int)$this->request->getPost('employee_id');
        $title      = trim((string)$this->request->getPost('document_title'));
        $docType    = $this->request->getPost('document_type');
        $expiryDate = $this->request->getPost('expiry_date') ?: null;

        if (empty($employeeId) || empty($title) || empty($docType)) {
            $this->session->setFlashdata('error', 'Document title and type are required.');
            return redirect()->back();
        }

        $filePath = 'vault/' . strtolower($docType) . '_' . time() . '.pdf';
        $fileSize = rand(120, 850) * 1024;

        $docFile = $this->request->getFile('document_file');
        if ($docFile && $docFile->isValid() && !$docFile->hasMoved()) {
            $docUploadDir = FCPATH . 'uploads/documents';
            if (!is_dir($docUploadDir)) {
                mkdir($docUploadDir, 0777, true);
            }
            $docName = $docFile->getRandomName();
            $docFile->move($docUploadDir, $docName);
            $filePath = 'uploads/documents/' . $docName;
            $fileSize = (int)$docFile->getSize();
        }

        $db = \Config\Database::connect();
        $docId = $db->table('employee_documents')->insert([
            'employee_id'    => $employeeId,
            'document_type'  => $docType,
            'document_title' => $title,
            'file_path'      => $filePath,
            'file_size'      => $fileSize,
            'expiry_date'    => $expiryDate,
            'is_verified'    => 1,
            'verified_by'    => $this->userId(),
            'uploaded_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->logAudit('UPLOAD_DOCUMENT', 'employee_docs', "Uploaded document '{$title}' ({$docType}) for employee #{$employeeId}.", $docId);
        $this->session->setFlashdata('success', "Document '{$title}' successfully added to employee vault.");
        return redirect()->to(site_url('employees/view/' . $employeeId));
    }

    /**
     * Delete document from vault
     */
    public function deleteDocument(int $docId)
    {
        $db = \Config\Database::connect();
        $doc = $db->table('employee_documents')->where('id', $docId)->get()->getFirstRow('array');

        if (!$doc) {
            $this->session->setFlashdata('error', 'Document not found.');
            return redirect()->back();
        }

        $employeeId = $doc['employee_id'];
        $db->table('employee_documents')->where('id', $docId)->delete();

        $this->logAudit('DELETE_DOCUMENT', 'employee_docs', "Deleted document '{$doc['document_title']}' for employee #{$employeeId}.", $docId);
        $this->session->setFlashdata('success', 'Document removed from vault.');
        return redirect()->to(site_url('employees/view/' . $employeeId));
    }

    /**
     * Delete / Archive an employee profile
     */
    public function delete(int $id)
    {
        // Enforce RBAC: employee.delete capability required
        if (!$this->hasPermission('employee.delete')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to delete or archive employees.');
            return redirect()->to(site_url('employees'));
        }

        $employeeModel = new EmployeeModel();
        $employee = $employeeModel->find($id);

        if (!$employee) {
            $this->session->setFlashdata('error', 'The requested employee profile was not found.');
            return redirect()->to(site_url('employees'));
        }

        // Prevent self-deletion
        if (!empty($this->currentUser['employee_id']) && (int)$this->currentUser['employee_id'] === $id) {
            $this->session->setFlashdata('error', 'Security Restriction: You cannot delete your own active employee account.');
            return redirect()->to(site_url('employees/view/' . $id));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Mark status as terminated / archived
        $employeeModel->update($id, [
            'employment_status' => 'terminated',
        ]);

        // 2. Soft-delete employee record
        $employeeModel->delete($id);

        // 3. Deactivate associated user login if any
        if (!empty($employee['user_id'])) {
            $db->table('users')->where('id', $employee['user_id'])->update(['status' => 'suspended']);
        }
        $db->table('users')->where('employee_id', $id)->update(['status' => 'suspended']);

        // 4. Remove salary structure profile for deleted employee
        $db->table('salary_structures')->where('employee_id', $id)->delete();

        $db->transComplete();

        $this->logAudit('DELETE_EMPLOYEE', 'employees', "Archived and removed employee {$employee['first_name']} {$employee['last_name']} ({$employee['employee_code']}).", $id);

        $this->session->setFlashdata('success', "Employee {$employee['first_name']} {$employee['last_name']} ({$employee['employee_code']}) has been successfully deleted.");
        return redirect()->to(site_url('employees'));
    }
}


