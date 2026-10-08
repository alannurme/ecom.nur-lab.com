<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\SettingModel;

class Category extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(50)
        ];

        return view('frontend/categories', $data);
    }
}
