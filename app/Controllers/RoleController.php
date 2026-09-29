<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RoleController extends BaseController
{
    /**
     * Display all roles and full RBAC permission matrix
     */
    public function index()
    {
        if (!$this->hasPermission('roles.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to manage roles and RBAC permissions.');
            return redirect()->to(site_url('dashboard'));
        }

        $roleModel = new RoleModel();

        $roles = $roleModel->getAllRolesWithStats();
        $groupedPermissions = $roleModel->getAllPermissionsGrouped();

        // Build role => permission_ids mapping
        $db = \Config\Database::connect();
        $mappings = $db->table('role_permissions')->get()->getResultArray();
        $rolePermMap = [];
        foreach ($mappings as $m) {
            $rolePermMap[$m['role_id']][] = (int)$m['permission_id'];
        }

        $data = [
            'roles'              => $roles,
            'groupedPermissions' => $groupedPermissions,
            'rolePermMap'        => $rolePermMap,
        ];

        return $this->render('roles/index', $data, 'Roles & RBAC Access Matrix');
    }

    /**
     * Update permissions for a specific role
     */
    public function update(int $roleId)
    {
        if (!$this->hasPermission('roles.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to modify roles and permissions.');
            return redirect()->to(site_url('dashboard'));
        }

        $roleModel = new RoleModel();
        $role = $roleModel->find($roleId);

        if (!$role) {
            $this->session->setFlashdata('error', 'Role not found.');
            return redirect()->to(site_url('roles'));
        }

        $permIds = $this->request->getPost('permissions') ?? [];

        // Protection: Super Admin must retain all permissions
        if ($role['slug'] === 'super_admin') {
            $db = \Config\Database::connect();
            $allPerms = $db->table('permissions')->select('id')->get()->getResultArray();
            $permIds = array_column($allPerms, 'id');
        }

        $success = $roleModel->syncPermissions($roleId, $permIds);

        if ($success) {
            $this->logAudit('UPDATE_RBAC', 'roles', "Updated permissions for role {$role['name']} (assigned " . count($permIds) . " permissions).", $roleId);
            $this->session->setFlashdata('success', "Permissions updated successfully for {$role['name']}.");
        } else {
            $this->session->setFlashdata('error', "Failed to update permissions for {$role['name']}.");
        }

        return redirect()->to(site_url('roles'));
    }
}
