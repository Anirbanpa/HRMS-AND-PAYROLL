<?php

namespace App\Models;

class SystemSettingModel extends BaseModel
{
    protected $table            = 'system_settings';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'category',
        'key_name',
        'key_value',
        'description',
    ];

    /**
     * Get setting value by key with fallback default
     *
     * @param string $keyName
     * @param mixed $default
     * @return mixed
     */
    public function getSetting(string $keyName, $default = null)
    {
        $setting = $this->where('key_name', $keyName)->first();
        return $setting ? $setting['key_value'] : $default;
    }

    /**
     * Fetch all settings as key => value map
     *
     * @return array
     */
    public function getAllAsMap(): array
    {
        $rows = $this->findAll();
        $map = [];
        foreach ($rows as $row) {
            $map[$row['key_name']] = $row['key_value'];
        }
        return $map;
    }
}
