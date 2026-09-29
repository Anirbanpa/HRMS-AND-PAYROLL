<?php

namespace App\Models;

/**
 * Class NotificationTemplateModel
 *
 * Module 36: Multi-channel Notification Templates (Email, SMS, WhatsApp, In-App)
 */
class NotificationTemplateModel extends BaseModel
{
    protected $table         = 'notification_templates';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'template_key',
        'title',
        'channel',
        'subject',
        'body_content',
        'variables',
        'is_active',
    ];
}
