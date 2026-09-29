<?php

namespace App\Models;

class UserModel extends BaseModel
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'employee_id',
        'username',
        'email',
        'password_hash',
        'role_id',
        'status',
        'two_factor_secret',
        'two_factor_enabled',
        'last_login_at',
        'last_login_ip',
        'remember_token',
    ];

    protected $validationRules  = [
        'username' => 'required|min_length[3]|max_length[60]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|max_length[100]|is_unique[users.email,id,{id}]',
        'role_id'  => 'required|is_natural_no_zero',
    ];

    /**
     * Find active user by username or email with role and employee profile
     *
     * @param string $identifier Username or Email
     * @return array|null
     */
    public function findByIdentifier(string $identifier): ?array
    {
        $altIdentifier = str_starts_with($identifier, 'demo.') 
            ? substr($identifier, 5) 
            : 'demo.' . $identifier;

        return $this->select('users.*, roles.name as role_name, roles.slug as role_slug, 
                             emp.first_name, emp.last_name, emp.employee_code, emp.profile_photo,
                             emp.department_id, emp.designation_id, emp.branch_id')
            ->join('roles', 'roles.id = users.role_id')
            ->join('employees emp', 'emp.id = users.employee_id', 'left')
            ->groupStart()
                ->where('users.username', $identifier)
                ->orWhere('users.username', $altIdentifier)
                ->orWhere('users.email', $identifier)
            ->groupEnd()
            ->where('users.deleted_at', null)
            ->first();
    }

    /**
     * Update last login timestamp and IP
     *
     * @param int $userId
     * @param string $ipAddress
     * @return bool
     */
    public function recordLogin(int $userId, string $ipAddress): bool
    {
        return $this->update($userId, [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ipAddress,
        ]);
    }
}
