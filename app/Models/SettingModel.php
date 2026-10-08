<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'business_settings';

    public function getSetting(string $type, $default = null)
    {
        $setting = $this->where('type', $type)->first();
        return $setting ? $setting['value'] : $default;
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
