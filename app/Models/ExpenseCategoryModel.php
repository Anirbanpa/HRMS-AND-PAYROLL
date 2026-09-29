<?php

namespace App\Models;

/**
 * Class ExpenseCategoryModel
 *
 * Module 24: Expense Categories & Claim Limits
 */
class ExpenseCategoryModel extends BaseModel
{
    protected $table         = 'expense_categories';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'company_id',
        'name',
        'code',
        'max_limit_per_claim',
        'requires_receipt',
        'description',
        'status',
    ];
}
