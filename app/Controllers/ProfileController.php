<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\ActivityLogModel;

class ProfileController extends BaseController
{
    /**
     * Display User Profile & Security Settings
     */
    public function index()
    {
        $userModel = new UserModel();
        $employeeModel = new EmployeeModel();
        $activityLogModel = new ActivityLogModel();

        $user = $userModel->select('users.*, roles.name as role_name, roles.slug as role_slug')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $this->userId())
            ->first();

        $employee = null;
        if (!empty($user['employee_id'])) {
            $employee = $employeeModel->get360Profile((int)$user['employee_id']);
        }

        // Recent security activity logs for this user
        $recentLogs = $activityLogModel->where('user_id', $this->userId())
            ->orderBy('id', 'DESC')
            ->findAll(10);

        $data = [
            'user'       => $user,
            'employee'   => $employee,
            'recentLogs' => $recentLogs,
        ];

        return $this->render('profile/index', $data, 'My Profile & Security Settings');
    }

    /**
     * Process password update
     */
    public function updatePassword()
    {
        $currentPassword = (string)$this->request->getPost('current_password');
        $newPassword     = (string)$this->request->getPost('new_password');
        $confirmPassword = (string)$this->request->getPost('confirm_password');

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $this->session->setFlashdata('error', 'All password fields are required.');
            return redirect()->to(site_url('profile'));
        }

        if ($newPassword !== $confirmPassword) {
            $this->session->setFlashdata('error', 'New password and confirm password do not match.');
            return redirect()->to(site_url('profile'));
        }

        if (strlen($newPassword) < 8) {
            $this->session->setFlashdata('error', 'New password must be at least 8 characters in length.');
            return redirect()->to(site_url('profile'));
        }

        $userModel = new UserModel();
        $user = $userModel->find($this->userId());

        if (!password_verify($currentPassword, $user['password_hash'])) {
            $this->session->setFlashdata('error', 'Your current password was entered incorrectly.');
            return redirect()->to(site_url('profile'));
        }

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $userModel->update($this->userId(), [
            'password_hash' => $newHash,
        ]);

        $this->logAudit('PASSWORD_CHANGE', 'auth', "User {$user['username']} changed their security password.", $this->userId());
        $this->session->setFlashdata('success', 'Your account password has been updated successfully.');

        return redirect()->to(site_url('profile'));
    }
}
