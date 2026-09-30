<?php

namespace App\Models;

class RoleModel extends BaseModel
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'description', 'is_system', 'hierarchy_level'];
    protected $validationRules  = [
        'name' => 'required|min_length[2]|max_length[50]',
        'slug' => 'required|min_length[2]|max_length[50]|is_unique[roles.slug,id,{id}]',
    ];

    /**
     * Get role with assigned permissions
     *
     * @param int $roleId
     * @return array|null
     */
    public function getRoleWithPermissions(int $roleId): ?array
    {
        $role = $this->find($roleId);
        if (!$role) {
            return null;
        }

        $db = \Config\Database::connect();
        $permissions = $db->table('role_permissions rp')
            ->select('p.id, p.module, p.name, p.slug, p.description')
            ->join('permissions p', 'p.id = rp.permission_id')
            ->where('rp.role_id', $roleId)
            ->get()
            ->getResultArray();

        $role['permissions'] = $permissions;
        $role['permission_slugs'] = array_column($permissions, 'slug');
        return $role;
    }

    /**
     * Get all roles with user count and permission count
     */
    public function getAllRolesWithStats(): array
    {
        $db = \Config\Database::connect();
        return $db->table('roles r')
            ->select('r.*, COUNT(DISTINCT u.id) as user_count, COUNT(DISTINCT rp.permission_id) as permission_count')
            ->join('users u', 'u.role_id = r.id', 'left')
            ->join('role_permissions rp', 'rp.role_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('r.hierarchy_level', 'ASC')
            ->orderBy('r.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get all system permissions grouped by module
     */
    public function getAllPermissionsGrouped(): array
    {
        $db = \Config\Database::connect();
        $perms = $db->table('permissions')->orderBy('module', 'ASC')->orderBy('id', 'ASC')->get()->getResultArray();
        $grouped = [];
        foreach ($perms as $p) {
            $grouped[$p['module']][] = $p;
        }
        return $grouped;
    }

    /**
     * Synchronize permissions for a role
     */
    public function syncPermissions(int $roleId, array $permissionIds): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $role = $this->find($roleId);
        $isSuperAdmin = ($role && $role['slug'] === 'super_admin');

        // Security rule: Only Super Admin may possess delete permissions
        if (!$isSuperAdmin && !empty($permissionIds)) {
            $deletePerms = $db->table('permissions')
                ->where('slug', 'employee.delete')
                ->orLike('slug', '.delete', 'before')
                ->get()->getResultArray();
            $delPermIds = array_column($deletePerms, 'id');
            $permissionIds = array_diff($permissionIds, $delPermIds);
        }

        $db->table('role_permissions')->where('role_id', $roleId)->delete();

        if (!empty($permissionIds)) {
            $batch = [];
            foreach ($permissionIds as $pId) {
                $batch[] = [
                    'role_id'       => $roleId,
                    'permission_id' => (int)$pId,
                ];
            }
            $db->table('role_permissions')->insertBatch($batch);
        }

        $db->transComplete();
        return $db->transStatus() !== false;
    }
}

