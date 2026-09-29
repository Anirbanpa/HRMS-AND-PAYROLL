<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\EmployeeModel;

class AuthController extends BaseController
{
    /**
     * Display login page or process authentication submission
     */
    public function login()
    {
        if ($this->isAuthenticated()) {
            return redirect()->to(site_url('dashboard'));
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $identifier = trim((string)$this->request->getPost('identifier'));
            $password   = (string)$this->request->getPost('password');

            if (empty($identifier) || empty($password)) {
                $this->session->setFlashdata('error', 'Please enter your username/email and password.');
                return redirect()->back()->withInput();
            }

            $userModel = new UserModel();
            $user = $userModel->findByIdentifier($identifier);

            if (!$user) {
                $this->session->setFlashdata('error', 'Invalid login credentials.');
                return redirect()->back()->withInput();
            }

            if ($user['status'] !== 'active') {
                $this->session->setFlashdata('error', "Your account is currently {$user['status']}. Please contact HR Administration.");
                return redirect()->back();
            }

            if (!password_verify($password, $user['password_hash'])) {
                $this->session->setFlashdata('error', 'Invalid password supplied.');
                return redirect()->back()->withInput();
            }

            // Authentication successful: Load role permissions
            $roleModel = new RoleModel();
            $roleData = $roleModel->getRoleWithPermissions((int)$user['role_id']);
            $permissions = $roleData['permission_slugs'] ?? [];

            // Set session variables
            $this->session->regenerate();
            $this->session->set([
                'user_id'       => $user['id'],
                'username'      => $user['username'],
                'email'         => $user['email'],
                'role_id'       => $user['role_id'],
                'role_slug'     => $user['role_slug'],
                'role_name'     => $user['role_name'],
                'employee_id'   => $user['employee_id'],
                'employee_code' => $user['employee_code'] ?? null,
                'full_name'     => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
                'permissions'   => $permissions,
                'logged_in'     => true,
            ]);

            // Update login timestamp & IP
            $userModel->recordLogin((int)$user['id'], $this->request->getIPAddress());

            // Audit log
            $this->logAudit('LOGIN', 'auth', "User {$user['username']} logged in successfully.", $user['id']);

            $this->session->setFlashdata('success', "Welcome back, {$user['first_name']}! You are signed in as {$user['role_name']}.");

            $redirectUrl = $this->session->get('redirect_url');
            $this->session->remove('redirect_url');
            if ($redirectUrl && !str_contains($redirectUrl, 'login')) {
                return redirect()->to($redirectUrl);
            }

            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }

    /**
     * Demo role switcher for testing all 7 access tiers seamlessly
     */
    public function switchDemo(string $roleSlug)
    {
        $allowed = ['super_admin', 'hr_admin', 'hr_executive', 'payroll_manager', 'accountant', 'manager', 'employee'];
        if (!in_array($roleSlug, $allowed, true)) {
            $this->session->setFlashdata('error', 'Invalid demo role selected.');
            return redirect()->to(site_url('login'));
        }

        $userModel = new UserModel();
        $user = $userModel->select('users.*, roles.name as role_name, roles.slug as role_slug, emp.first_name, emp.last_name, emp.employee_code')
            ->join('roles', 'roles.id = users.role_id')
            ->join('employees emp', 'emp.id = users.employee_id', 'left')
            ->where('roles.slug', $roleSlug)
            ->first();

        if (!$user) {
            $this->session->setFlashdata('error', "No user found for role: {$roleSlug}");
            return redirect()->to(site_url('login'));
        }

        $roleModel = new RoleModel();
        $roleData = $roleModel->getRoleWithPermissions((int)$user['role_id']);
        $permissions = $roleData['permission_slugs'] ?? [];

        $this->session->regenerate();
        $this->session->set([
            'user_id'       => $user['id'],
            'username'      => $user['username'],
            'email'         => $user['email'],
            'role_id'       => $user['role_id'],
            'role_slug'     => $user['role_slug'],
            'role_name'     => $user['role_name'],
            'employee_id'   => $user['employee_id'],
            'employee_code' => $user['employee_code'] ?? null,
            'full_name'     => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
            'permissions'   => $permissions,
            'logged_in'     => true,
        ]);

        $this->logAudit('DEMO_SWITCH', 'auth', "Switched role context to {$user['role_name']} ({$user['username']})", $user['id']);
        $this->session->setFlashdata('success', "Active session switched to: {$user['role_name']} ({$user['username']}).");

        return redirect()->to(site_url('dashboard'));
    }

    /**
     * Terminate user session
     */
    public function logout()
    {
        if ($this->isAuthenticated()) {
            $this->logAudit('LOGOUT', 'auth', "User {$this->currentUser['username']} logged out.");
        }
        $this->session->remove([
            'user_id',
            'username',
            'email',
            'role_id',
            'role_slug',
            'role_name',
            'employee_id',
            'employee_code',
            'full_name',
            'permissions',
            'logged_in',
        ]);
        $this->session->regenerate(true);
        $this->session->setFlashdata('success', 'You have been securely logged out.');
        return redirect()->to(site_url('login'));
    }
}
