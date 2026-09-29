<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Verify user session before processing route
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->has('user_id')) {
            // Save attempted URI for post-login redirect
            $session->set('redirect_url', current_url());
            $session->setFlashdata('error', 'Please authenticate with your credentials to access the Enterprise HRMS.');
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed
    }
}
