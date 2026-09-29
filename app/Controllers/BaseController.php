<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ActivityLogModel;
use App\Models\RoleModel;

/**
 * Class BaseController
 *
 * BaseController provides foundational services, unified RBAC session checks,
 * structured view rendering, and audit activity logging for all Enterprise HRMS controllers.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form', 'text', 'html'];

    /**
     * Active Session service
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Cached current user record
     *
     * @var array|null
     */
    protected ?array $currentUser = null;

    /**
     * Cached permission slugs for current user's role
     *
     * @var array
     */
    protected array $userPermissions = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do not edit this line
        parent::initController($request, $response, $logger);

        // Preload session service
        $this->session = service('session');

        // Populate authenticated user if logged in
        if ($this->session->has('user_id')) {
            $this->currentUser = [
                'id'            => $this->session->get('user_id'),
                'username'      => $this->session->get('username'),
                'email'         => $this->session->get('email'),
                'role_id'       => $this->session->get('role_id'),
                'role_slug'     => $this->session->get('role_slug'),
                'role_name'     => $this->session->get('role_name'),
                'employee_id'   => $this->session->get('employee_id'),
                'employee_code' => $this->session->get('employee_code'),
                'full_name'     => $this->session->get('full_name'),
            ];

            // Always ensure freshest permissions for current user's role
            $roleModel = new RoleModel();
            $roleData = $roleModel->getRoleWithPermissions((int)$this->currentUser['role_id']);
            $this->userPermissions = $roleData['permission_slugs'] ?? [];
            $this->session->set('permissions', $this->userPermissions);
        }
    }

    /**
     * Get currently logged-in user profile
     *
     * @return array|null
     */
    protected function user(): ?array
    {
        return $this->currentUser;
    }

    /**
     * Get currently logged-in user ID
     */
    protected function userId(): ?int
    {
        return isset($this->currentUser['id']) ? (int)$this->currentUser['id'] : null;
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return !empty($this->currentUser);
    }

    /**
     * Check if current user has any of the specified roles
     *
     * @param string|array $roles
     * @return bool
     */
    protected function hasRole($roles): bool
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        if (is_string($roles)) {
            $roles = [$roles];
        }

        return in_array($this->currentUser['role_slug'], $roles, true);
    }

    /**
     * Check if current user possesses a specific permission slug
     *
     * @param string $permissionSlug
     * @return bool
     */
    protected function hasPermission(string $permissionSlug): bool
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        // Super Admin bypasses all checks
        if ($this->currentUser['role_slug'] === 'super_admin') {
            return true;
        }

        return in_array($permissionSlug, $this->userPermissions, true);
    }

    /**
     * Record an audit trail log
     *
     * @param string $action
     * @param string $module
     * @param string $description
     * @param int|null $recordId
     * @return void
     */
    protected function logAudit(string $action, string $module, string $description, ?int $recordId = null): void
    {
        $logModel = new ActivityLogModel();
        $userId = $this->currentUser['id'] ?? null;
        $logModel->recordEvent($userId, $action, $module, $description, $recordId);
    }

    /**
     * Render a view wrapped in the master enterprise layout
     *
     * @param string $viewPath
     * @param array $data
     * @param string $pageTitle
     * @return string
     */
    protected function render(string $viewPath, array $data = [], string $pageTitle = 'Enterprise HRMS'): string
    {
        $unreadCount = 0;
        $recentNotifs = [];
        $currentEmpId  = $this->currentUser['employee_id'] ?? null;
        $currentUserId = $this->currentUser['id'] ?? null;
        
        if ($currentEmpId || $currentUserId) {
            try {
                $db = \Config\Database::connect();
                $builderUnread = $db->table('system_notifications')->where('is_read', 0);
                if ($currentEmpId && $currentUserId) {
                    $builderUnread->groupStart()->where('employee_id', $currentEmpId)->orWhere('user_id', $currentUserId)->groupEnd();
                } elseif ($currentEmpId) {
                    $builderUnread->where('employee_id', $currentEmpId);
                } else {
                    $builderUnread->where('user_id', $currentUserId);
                }
                $unreadCount = $builderUnread->countAllResults();

                $builderRecent = $db->table('system_notifications');
                if ($currentEmpId && $currentUserId) {
                    $builderRecent->groupStart()->where('employee_id', $currentEmpId)->orWhere('user_id', $currentUserId)->groupEnd();
                } elseif ($currentEmpId) {
                    $builderRecent->where('employee_id', $currentEmpId);
                } else {
                    $builderRecent->where('user_id', $currentUserId);
                }
                $recentNotifs = $builderRecent->orderBy('id', 'DESC')
                    ->limit(6)
                    ->get()
                    ->getResultArray();
            } catch (\Throwable $e) {
                log_message('warning', 'Notification query failed: ' . $e->getMessage());
            }
        }

        $viewData = array_merge([
            'pageTitle'           => $pageTitle,
            'currentUser'         => $this->currentUser,
            'userPermissions'     => $this->userPermissions,
            'currentRoleSlug'     => $this->currentUser['role_slug'] ?? 'guest',
            'unreadNotifCount'    => $unreadCount,
            'recentNotifications' => $recentNotifs,
            'flashSuccess'        => $this->session->getFlashdata('success'),
            'flashError'          => $this->session->getFlashdata('error'),
            'flashWarning'        => $this->session->getFlashdata('warning'),
        ], $data);

        $viewData['content'] = view($viewPath, $viewData);
        return view('layouts/main', $viewData);
    }

    /**
     * Return standardized JSON success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return ResponseInterface
     */
    protected function jsonSuccess($data = null, string $message = 'Success', int $status = 200): ResponseInterface
    {
        return $this->response->setStatusCode($status)->setJSON([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Return standardized JSON error response
     *
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return ResponseInterface
     */
    protected function jsonError(string $message = 'An error occurred', int $status = 400, array $errors = []): ResponseInterface
    {
        return $this->response->setStatusCode($status)->setJSON([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ]);
    }
}
