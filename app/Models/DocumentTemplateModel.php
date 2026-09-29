<?php

namespace App\Models;

class DocumentTemplateModel extends BaseModel
{
    protected $table            = 'document_templates';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'template_code',
        'name',
        'category',
        'subject',
        'body_content',
        'available_tokens',
        'is_active',
    ];
}
