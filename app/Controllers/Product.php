<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Product extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function detail($slug)
    {
        $productModel = new ProductModel();
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();

        $product = $this->db->table('products p')
            ->select('p.*, u.file_name as thumbnail_path, c.name as category_name')
            ->join('uploads u', 'p.thumbnail_img = u.id', 'left')
            ->join('categories c', 'p.category_id = c.id', 'left')
            ->where('p.slug', $slug)
            ->where('p.published', 1)
            ->get()
            ->getRowArray();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        $relatedProducts = $productModel->getLatestProducts(6);

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'product' => $product,
            'final_price' => $productModel->calculateFinalPrice($product),
            'related_products' => $relatedProducts,
            'productModel' => $productModel
        ];

        return view('frontend/product_details', $data);
    }

    public function list()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $keyword = $this->request->getGet('keyword');
        
        $builder = $this->db->table('products p');
        $builder->select('p.*, u.file_name as thumbnail_path, c.name as category_name');
        $builder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
        $builder->join('categories c', 'p.category_id = c.id', 'left');
        $builder->where('p.published', 1);

        if (!empty($keyword)) {
            $builder->like('p.name', $keyword);
        }

        $products = $builder->orderBy('p.id', 'DESC')->limit(24)->get()->getResultArray();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'products' => $products,
            'keyword' => $keyword,
            'productModel' => $productModel
        ];

        return view('frontend/category_products', $data);
    }
}
