<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    /**
     * Check if user possesses specific permission slug
     *
     * Example route: $routes->get('employees/create', 'Employee::create', ['filter' => 'permission:employee.create']);
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->has('user_id')) {
            return redirect()->to(site_url('login'));
        }

        $userRoleSlug = $session->get('role_slug');
        if ($userRoleSlug === 'super_admin') {
            return;
        }

        $permissions = $session->get('permissions') ?? [];

        if (!empty($arguments)) {
            $requiredPerm = $arguments[0];
            if (!in_array($requiredPerm, $permissions, true)) {
                $session->setFlashdata('error', "Access Denied: Missing required permission [{$requiredPerm}].");
                return redirect()->to(site_url('dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed
    }
}
