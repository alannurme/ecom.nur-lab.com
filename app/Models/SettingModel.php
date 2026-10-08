<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'business_settings';

    protected $allowedFields = ['type', 'value', 'created_at', 'updated_at'];

    public function getSetting(string $type, $default = null)
    {
        $setting = $this->where('type', $type)->first();
        return $setting ? $setting['value'] : $default;
    }

    public function saveSetting(string $type, $value)
    {
        $existing = $this->where('type', $type)->first();
        if ($existing) {
            return $this->where('type', $type)->set(['value' => $value])->update();
        }
        return $this->insert(['type' => $type, 'value' => $value]);
    }

    public function getSliders(): array
    {
        $sliderJson = $this->getSetting('home_slider_images');
        if (!$sliderJson) {
            return [];
        }

        $uploadIds = json_decode($sliderJson, true);
        if (empty($uploadIds) || !is_array($uploadIds)) {
            return [];
        }

        $db = \Config\Database::connect();
        $builder = $db->table('uploads');
        $query = $builder->whereIn('id', $uploadIds)->get();
        
        return $query->getResultArray();
    }
}
