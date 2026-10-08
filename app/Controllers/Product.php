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

        // Fetch gallery photos
        $photosArray = [];
        if (!empty($product['photos'])) {
            $photoIds = explode(',', $product['photos']);
            $photoIds = array_filter(array_map('trim', $photoIds));
            if (!empty($photoIds)) {
                $uploads = $this->db->table('uploads')->whereIn('id', $photoIds)->get()->getResultArray();
                foreach ($uploads as $up) {
                    $photosArray[] = $up['file_name'];
                }
            }
        }
        if (empty($photosArray) && !empty($product['thumbnail_path'])) {
            $photosArray[] = $product['thumbnail_path'];
        }

        // Fetch Brand Name
        $brandName = '';
        if (!empty($product['brand_id'])) {
            $brand = $this->db->table('brands')->where('id', $product['brand_id'])->get()->getRowArray();
            if ($brand) {
                $brandName = $brand['name'];
            }
        }

        // Fetch Wholesale prices if applicable
        $wholesalePrices = [];
        if (!empty($product['wholesale_product'])) {
            $wsRes = $this->db->table('wholesale_prices wp')
                ->join('product_stocks ps', 'wp.product_stock_id = ps.id', 'inner')
                ->where('ps.product_id', $product['id'])
                ->get()
                ->getResultArray();
            $wholesalePrices = $wsRes;
        }

        $relatedProducts = $productModel->getLatestProducts(6);

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'product' => $product,
            'photos' => $photosArray,
            'brand_name' => $brandName,
            'wholesale_prices' => $wholesalePrices,
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
        $selectedCatId = (int)$this->request->getGet('cat_id');
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

        $page = (int)($this->request->getGet('page') ?? 1);
        if ($page < 1) $page = 1;
        $perPage = 60;

        $builder = $this->db->table('products p');
        $builder->select('p.*, u.file_name as thumbnail_path, c.name as category_name, b.name as brand_name');
        $builder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
        $builder->join('categories c', 'p.category_id = c.id', 'left');
        $builder->join('brands b', 'p.brand_id = b.id', 'left');
        $builder->where('p.published', 1);

        if (!empty($keyword)) {
            $builder->like('p.name', $keyword);
        }

        if (!empty($selectedCatId)) {
            $descendantIds = $categoryModel->getAllDescendantIds($selectedCatId);
            $catIds = array_merge([$selectedCatId], $descendantIds);
            $builder->whereIn('p.category_id', $catIds);
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

        // Count total items for pagination
        $totalItems = $builder->countAllResults(false);

        $products = $builder->limit($perPage, ($page - 1) * $perPage)
                            ->get()
                            ->getResultArray();

        $totalPages = ceil($totalItems / $perPage);

        // Fetch Brands for Filter Sidebar
        $brands = $this->db->table('brands')->select('id, name')->orderBy('name', 'ASC')->get()->getResultArray();

        $data = [
            'site_name'        => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories'       => $categoryModel->getMainCategories(50),
            'brands'           => $brands,
            'products'         => $products,
            'keyword'          => $keyword,
            'selected_cat_id'  => $selectedCatId,
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
            'productModel'     => $productModel,
            'current_page'     => $page,
            'total_pages'      => $totalPages,
            'total_items'      => $totalItems,
            'per_page'         => $perPage
        ];

        return view('frontend/category_products', $data);
    }
}
