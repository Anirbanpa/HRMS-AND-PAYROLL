<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Check if user role matches one of the allowed roles
     *
     * Example route: $routes->get('admin', 'Admin::index', ['filter' => 'role:super_admin,hr_admin']);
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->has('user_id')) {
            return redirect()->to(site_url('login'));
        }

        $userRoleSlug = $session->get('role_slug');

        // Super Admin always allowed
        if ($userRoleSlug === 'super_admin') {
            return;
        }

        if (!empty($arguments) && !in_array($userRoleSlug, $arguments, true)) {
            $session->setFlashdata('error', 'Access Denied: Your account role does not have authorization for this area.');
            return redirect()->to(site_url('dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed
    }
}
