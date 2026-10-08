<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $db = \Config\Database::connect();
        $brands = $db->table('brands b')
            ->select('b.*, u.file_name as logo_path')
            ->join('uploads u', 'b.logo = u.id', 'left')
            ->limit(12)
            ->get()
            ->getResultArray();

        // Fetch category-wise products for home page showcases
        $mainCats = $categoryModel->getMainCategories(4);
        $categoryWiseProducts = [];
        foreach ($mainCats as $cat) {
            $catProducts = $productModel->getProductsByCategory($cat['id'], 6);
            if (!empty($catProducts)) {
                $categoryWiseProducts[] = [
                    'category' => $cat,
                    'products' => $catProducts
                ];
            }
        }

        // Fetch top sellers/shops
        $shops = $db->table('shops s')
            ->select('s.*, u.file_name as logo_path')
            ->join('uploads u', 's.logo = u.id', 'left')
            ->limit(6)
            ->get()
            ->getResultArray();

        // Fetch auction products
        $auction_products = $db->table('products p')
            ->select('p.*, u.file_name as thumbnail_path')
            ->join('uploads u', 'p.thumbnail_img = u.id', 'left')
            ->where('p.auction_product', 1)
            ->where('p.published', 1)
            ->where('p.approved', 1)
            ->limit(8)
            ->get()
            ->getResultArray();

        // Fetch wholesale products
        $wholesale_products = $db->table('products p')
            ->select('p.*, u.file_name as thumbnail_path')
            ->join('uploads u', 'p.thumbnail_img = u.id', 'left')
            ->where('p.wholesale_product', 1)
            ->where('p.published', 1)
            ->where('p.approved', 1)
            ->limit(8)
            ->get()
            ->getResultArray();

        $data = [
            'site_name'             => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'sliders'               => $settingModel->getSliders(),
            'categories'            => $categoryModel->getMainCategories(12),
            'featured_categories'   => $categoryModel->getFeaturedCategories(8),
            'hot_categories'        => $categoryModel->getHotCategories(12),
            'featured_products'     => $productModel->getFeaturedProducts(10),
            'todays_deals'          => $productModel->getTodaysDeals(10),
            'latest_products'       => $productModel->getLatestProducts(24),
            'auction_products'      => $auction_products,
            'wholesale_products'    => $wholesale_products,
            'category_wise_products'=> $categoryWiseProducts,
            'home_showcase_categories' => $categoryModel->getHomeShowcaseCategories(6),
            'shops'                 => $shops,
            'brands'                => $brands,
            'productModel'          => $productModel
        ];

        return view('frontend/home', $data);
    }
}
