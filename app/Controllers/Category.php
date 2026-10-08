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

    public function show($slug)
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();
        $productModel = new \App\Models\ProductModel();
        $db = \Config\Database::connect();

        $page = (int)($this->request->getGet('page') ?? 1);
        if ($page < 1) $page = 1;
        $perPage = 60;

        $category = $db->table('categories')->where('slug', $slug)->get()->getRowArray();

        $selectedBrandId = (int)$this->request->getGet('brand_id');
        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');
        $sortBy = $this->request->getGet('sort_by') ?? 'latest';
        $discountedOnly = $this->request->getGet('discounted');
        $inStock = $this->request->getGet('in_stock');
        $cod = $this->request->getGet('cod');
        $freeShipping = $this->request->getGet('free_shipping');
        $featured = $this->request->getGet('featured');
        $todaysDeal = $this->request->getGet('todays_deal');
        $minRating = $this->request->getGet('min_rating');
        $hasWarranty = $this->request->getGet('warranty');
        $wholesale = $this->request->getGet('wholesale');

        $builder = $db->table('products p');
        $builder->select('p.*, u.file_name as thumbnail_path, c.name as category_name, b.name as brand_name');
        $builder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
        $builder->join('categories c', 'p.category_id = c.id', 'left');
        $builder->join('brands b', 'p.brand_id = b.id', 'left');
        $builder->where('p.published', 1);

        if ($category) {
            // Get parent category and all its descendant subcategories recursively
            $descendantIds = $categoryModel->getAllDescendantIds($category['id']);
            $catIds = array_merge([$category['id']], $descendantIds);
            $builder->whereIn('p.category_id', $catIds);
        } else {
            $builder->like('c.slug', $slug);
        }

        if (!empty($selectedBrandId)) {
            $builder->where('p.brand_id', $selectedBrandId);
        }

        if (is_numeric($minPrice) && $minPrice >= 0) {
            $builder->where('p.unit_price >=', (float)$minPrice);
        }

        if (is_numeric($maxPrice) && $maxPrice > 0) {
            $builder->where('p.unit_price <=', (float)$maxPrice);
        }

        if (!empty($discountedOnly)) {
            $builder->where('p.discount >', 0);
        }

        if (!empty($inStock)) {
            $builder->where('p.current_stock >', 0);
        }

        if (!empty($cod)) {
            $builder->where('p.cash_on_delivery', 1);
        }

        if (!empty($freeShipping)) {
            $builder->groupStart()
                    ->where('p.shipping_cost', 0)
                    ->orWhere('p.shipping_type', 'free')
                    ->groupEnd();
        }

        if (!empty($featured)) {
            $builder->where('p.featured', 1);
        }

        if (!empty($todaysDeal)) {
            $builder->where('p.todays_deal', 1);
        }

        if (is_numeric($minRating) && $minRating > 0) {
            $builder->where('p.rating >=', (float)$minRating);
        }

        if (!empty($hasWarranty)) {
            $builder->where('p.has_warranty', 1);
        }

        if (!empty($wholesale)) {
            $builder->where('p.wholesale_product', 1);
        }

        // Sorting
        switch ($sortBy) {
            case 'price_low_high':
                $builder->orderBy('p.unit_price', 'ASC');
                break;
            case 'price_high_low':
                $builder->orderBy('p.unit_price', 'DESC');
                break;
            case 'name_asc':
                $builder->orderBy('p.name', 'ASC');
                break;
            case 'latest':
            default:
                $builder->orderBy('p.id', 'DESC');
                break;
        }

        $totalItems = $builder->countAllResults(false);

        $products = $builder->limit($perPage, ($page - 1) * $perPage)
                            ->get()
                            ->getResultArray();

        $totalPages = ceil($totalItems / $perPage);

        $subcategories = [];
        if (!empty($category['id'])) {
            $subcategories = $categoryModel->getAllSubcategoriesRecursive((int)$category['id']);
        }

        $brands = $db->table('brands')->select('id, name')->orderBy('name', 'ASC')->get()->getResultArray();

        $data = [
            'site_name'        => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories'       => $categoryModel->getMainCategories(50),
            'brands'           => $brands,
            'category'         => $category,
            'category_name'    => $category['name'] ?? 'Category Products',
            'subcategories'    => $subcategories,
            'selected_cat_id'  => $category['id'] ?? null,
            'selected_brand_id'=> $selectedBrandId,
            'min_price'        => $minPrice,
            'max_price'        => $maxPrice,
            'sort_by'          => $sortBy,
            'discounted_only'  => $discountedOnly,
            'in_stock'         => $inStock,
            'cod'              => $cod,
            'free_shipping'    => $freeShipping,
            'featured'         => $featured,
            'todays_deal'      => $todaysDeal,
            'min_rating'       => $minRating,
            'warranty'         => $hasWarranty,
            'wholesale'        => $wholesale,
            'products'         => $products,
            'productModel'     => $productModel,
            'current_page'     => $page,
            'total_pages'      => $totalPages,
            'total_items'      => $totalItems,
            'per_page'         => $perPage
        ];

        return view('frontend/category_products', $data);
    }
}
