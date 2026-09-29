<?php

namespace App\Controllers;

use App\Models\BranchModel;
use App\Models\DesignationModel;
use App\Models\DepartmentModel;

class OrganizationController extends BaseController
{
    public function index()
    {
        if (!$this->hasPermission('company.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to manage organization settings.');
            return redirect()->to(site_url('dashboard'));
        }

        $branchModel      = new BranchModel();
        $designationModel = new DesignationModel();
        $departmentModel  = new DepartmentModel();
        $db               = \Config\Database::connect();

        $company       = $db->table('companies')->where('id', 1)->get()->getFirstRow('array');
        $branches      = $branchModel->getBranchesWithStats();
        $designations  = $designationModel->getDesignationsWithDetails();
        $payGrades     = $db->table('pay_grades')->get()->getResultArray();
        $financialYears= $db->table('financial_years')->get()->getResultArray();
        $roles         = $db->table('roles')->get()->getResultArray();

        $data = [
            'company'        => $company,
            'branches'       => $branches,
            'designations'   => $designations,
            'payGrades'      => $payGrades,
            'financialYears' => $financialYears,
            'roles'          => $roles,
        ];

        return $this->render('organization/index', $data, 'Organization & Enterprise Setup');
    }
}
