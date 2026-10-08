<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\SettingModel;

class Brand extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();
        $db = \Config\Database::connect();

        $brands = $db->table('brands b')
            ->select('b.*, u.file_name as logo_path')
            ->join('uploads u', 'b.logo = u.id', 'left')
            ->get()
            ->getResultArray();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'brands' => $brands
        ];

        return view('frontend/brands', $data);
    }
}
