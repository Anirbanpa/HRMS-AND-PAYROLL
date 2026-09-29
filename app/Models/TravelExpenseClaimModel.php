<?php

namespace App\Models;

/**
 * Class TravelExpenseClaimModel
 *
 * Module 39: Travel Expense Claims & Itemized Receipts
 */
class TravelExpenseClaimModel extends BaseModel
{
    protected $table         = 'travel_expense_claims';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'travel_request_id',
        'employee_id',
        'expense_category',
        'bill_date',
        'bill_number',
        'amount',
        'approved_amount',
        'receipt_path',
        'remarks',
        'status',
    ];
}
