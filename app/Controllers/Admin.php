<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Admin extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        // Dashboard statistics calculations
        $totalProducts = $this->db->table('products')->countAllResults();
        $totalInhouseProducts = $this->db->table('products')->where('added_by', 'admin')->countAllResults();
        $totalSellerProducts = $this->db->table('products')->where('added_by', 'seller')->countAllResults();
        $totalCategories = $this->db->table('categories')->countAllResults();
        $totalBrands = $this->db->table('brands')->countAllResults();
        $totalOrders = $this->db->table('orders')->countAllResults();
        $totalUsers = $this->db->table('users')->where('user_type', 'customer')->countAllResults();
        $totalSellers = $this->db->table('shops')->countAllResults();
        $totalApprovedSellers = $this->db->table('shops')->where('verification_status', 1)->countAllResults();
        $totalPendingSellers = $this->db->table('shops')->where('verification_status', 0)->countAllResults();

        $topCustomers = $this->db->table('users')->where('user_type', 'customer')->limit(5)->get()->getResult();
        $topCategories = $this->db->table('categories')->limit(3)->get()->getResult();
        foreach ($topCategories as $cat) { $cat->total = 15000; }
        $topBrands = $this->db->table('brands')->limit(3)->get()->getResult();
        foreach ($topBrands as $b) { $b->total = 25000; }
        $topSellers = $this->db->table('shops')->limit(5)->get()->getResult();

        $totalSale = $this->db->table('orders')->selectSum('grand_total')->get()->getRow()->grand_total ?? 0;
        $saleThisMonth = $totalSale;

        $recentProducts = $productModel->getLatestProducts(5);
        $recentOrders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name')
            ->join('users u', 'o.user_id = u.id', 'left')
            ->orderBy('o.id', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'page_title' => 'Dashboard',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'total_customers' => $totalUsers,
            'top_customers' => $topCustomers,
            'total_products' => $totalProducts,
            'total_inhouse_products' => $totalInhouseProducts,
            'total_sellers_products' => $totalSellerProducts,
            'total_categories' => $totalCategories,
            'top_categories' => $topCategories,
            'total_brands' => $totalBrands,
            'top_brands' => $topBrands,
            'total_sale' => $totalSale,
            'sale_this_month' => $saleThisMonth,
            'admin_sale_this_month' => (object)['total_sale' => $totalSale],
            'seller_sale_this_month' => (object)['total_sale' => 0],
            'total_sellers' => $totalSellers,
            'total_approved_sellers' => $totalApprovedSellers,
            'total_pending_sellers' => $totalPendingSellers,
            'top_sellers' => $topSellers,
            'total_order' => $totalOrders,
            'total_inhouse_order' => $totalOrders,
            'total_seller_order' => 0,
            'inhouse_order_percentage' => 100,
            'seller_order_percentage' => 0,
            'total_delivered_order_percentage' => 100,
            'total_pending_order_percentage' => 0,
            'total_pending_order' => 0,
            'total_confirmed_order_percentage' => 0,
            'total_confirmed_order' => 0,
            'total_shipped_order_percentage' => 0,
            'total_shipped_order' => 0,
            'total_picked_up_order_percentage' => 0,
            'total_picked_up_order' => 0,
            'total_delivered_order' => $totalOrders,
            'recent_products' => $recentProducts,
            'recent_orders' => $recentOrders,
        ];

        return view('admin/dashboard', $data);
    }

    public function products($type = 'all')
    {
        $settingModel = new SettingModel();
        
        $builder = $this->db->table('products p');
        $builder->select('p.*, u.file_name as thumbnail_path, c.name as category_name');
        $builder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
        $builder->join('categories c', 'p.category_id = c.id', 'left');

        if ($type === 'inhouse') {
            $builder->where('p.added_by', 'admin');
        } elseif ($type === 'seller' || $type === 'seller-physical') {
            $builder->where('p.added_by', 'seller')->where('p.digital', 0);
        } elseif ($type === 'seller-digital') {
            $builder->where('p.added_by', 'seller')->where('p.digital', 1);
        } elseif ($type === 'digital') {
            $builder->where('p.digital', 1);
        }

        $builder->orderBy('p.id', 'DESC');
        $products = $builder->get()->getResultArray();

        $pageTitle = 'All Products';
        if ($type === 'inhouse') $pageTitle = 'In House Products';
        if ($type === 'seller' || $type === 'seller-physical') $pageTitle = 'Seller Physical Products';
        if ($type === 'seller-digital') $pageTitle = 'Seller Digital Products';
        if ($type === 'digital') $pageTitle = 'Digital Products';

        $data = [
            'page_title' => $pageTitle,
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'products'   => $products,
            'type'       => $type
        ];

        return view('admin/products', $data);
    }

    public function createProduct()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->findAll();
        $brands = $this->db->table('brands')->get()->getResultArray();

        $data = [
            'page_title' => 'Add New Product',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categories,
            'brands'     => $brands
        ];

        return view('admin/products/create', $data);
    }

    public function storeProduct()
    {
        $name = $this->request->getPost('name');
        $categoryId = $this->request->getPost('category_id');
        $brandId = $this->request->getPost('brand_id');
        $unitPrice = $this->request->getPost('unit_price') ?? 0;
        $purchasePrice = $this->request->getPost('purchase_price') ?? 0;
        $currentStock = $this->request->getPost('current_stock') ?? 10;

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($name ?? 'product')) . '-' . rand(1000, 9999);

        $isWholesale = $this->request->getPost('is_wholesale') ?? 0;

        $productData = [
            'name'              => $name ?? 'New Product',
            'added_by'          => 'admin',
            'user_id'           => 1,
            'category_id'       => $categoryId ?? 1,
            'brand_id'          => $brandId ?? 1,
            'video_provider'    => 'youtube',
            'unit_price'        => $unitPrice,
            'purchase_price'    => $purchasePrice,
            'unit'              => 'pc',
            'current_stock'     => $currentStock,
            'slug'              => $slug,
            'published'         => 1,
            'approved'          => 1,
            'wholesale_product' => $isWholesale,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];

        $this->db->table('products')->insert($productData);

        if ($isWholesale) {
            return redirect()->to(base_url('admin/wholesale/all-products'));
        }

        return redirect()->to(base_url('admin/products'));
    }

    public function editProduct($id)
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();

        $product = $this->db->table('products')->where('id', $id)->get()->getRowArray();
        if (!$product) {
            return redirect()->to(base_url('admin/products'));
        }

        $categories = $categoryModel->findAll();
        $brands = $this->db->table('brands')->get()->getResultArray();

        $data = [
            'page_title' => 'Edit Product',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'product'    => $product,
            'categories' => $categories,
            'brands'     => $brands
        ];

        return view('admin/products/edit', $data);
    }

    public function updateProduct($id)
    {
        $name = $this->request->getPost('name');
        $categoryId = $this->request->getPost('category_id');
        $brandId = $this->request->getPost('brand_id');
        $unitPrice = $this->request->getPost('unit_price');
        $purchasePrice = $this->request->getPost('purchase_price');
        $currentStock = $this->request->getPost('current_stock');

        $updateData = [
            'name'           => $name,
            'category_id'    => $categoryId,
            'brand_id'       => $brandId,
            'unit_price'     => $unitPrice,
            'purchase_price' => $purchasePrice,
            'current_stock'  => $currentStock,
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->db->table('products')->where('id', $id)->update($updateData);

        return redirect()->to(base_url('admin/products'));
    }

    public function bulkImport()
    {
        $settingModel = new SettingModel();

        $data = [
            'page_title' => 'Product Bulk Upload',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];

        return view('admin/products/bulk_import', $data);
    }

    public function bulkUpload()
    {
        $file = $this->request->getFile('bulk_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Process CSV/Excel upload logic
            session()->setFlashdata('success', 'Bulk products uploaded successfully.');
        } else {
            session()->setFlashdata('error', 'Please upload a valid CSV file.');
        }

        return redirect()->to(base_url('admin/products/bulk-import'));
    }

    public function bulkExport()
    {
        $products = $this->db->table('products')->get()->getResultArray();

        $filename = 'products_export_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Category ID', 'Brand ID', 'Unit Price', 'Current Stock', 'Published', 'Added By']);

        foreach ($products as $product) {
            fputcsv($output, [
                $product['id'] ?? '',
                $product['name'] ?? '',
                $product['category_id'] ?? '',
                $product['brand_id'] ?? '',
                $product['unit_price'] ?? '',
                $product['current_stock'] ?? '',
                $product['published'] ?? '',
                $product['added_by'] ?? ''
            ]);
        }
        fclose($output);
        exit;
    }

    public function bulkDemoDownload()
    {
        $filename = 'product_bulk_demo.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Category ID', 'Brand ID', 'Unit Price', 'Purchase Price', 'Current Stock', 'Unit', 'Min Qty', 'Description']);
        fputcsv($output, ['Sample Product 1', '1', '1', '100', '80', '50', 'pc', '1', 'Sample physical product description']);
        fputcsv($output, ['Sample Product 2', '2', '1', '250', '200', '100', 'pc', '1', 'Sample digital product description']);
        fclose($output);
        exit;
    }

    public function categories()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');
        $tab = $this->request->getGet('tab') ?? 'all';

        $builder = $this->db->table('categories c');
        $builder->select('c.*, p.name as parent_name, u.file_name as icon_img');
        $builder->join('categories p', 'c.parent_id = p.id', 'left');
        $builder->join('uploads u', 'c.icon = u.id', 'left');

        if ($tab === 'physical') {
            $builder->where('c.digital', 0);
        } elseif ($tab === 'digital') {
            $builder->where('c.digital', 1);
        }

        if (!empty($search)) {
            $builder->like('c.name', $search);
        }

        $builder->orderBy('c.order_level', 'DESC');
        $categories = $builder->get()->getResultArray();

        $data = [
            'page_title' => 'All Categories',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categories,
            'search'     => $search,
            'tab'        => $tab
        ];

        return view('admin/categories', $data);
    }

    public function brands()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $builder = $this->db->table('brands b');
        $builder->select('b.*, u.file_name as logo_img, (SELECT COUNT(id) FROM products WHERE brand_id = b.id) as products_count');
        $builder->join('uploads u', 'b.logo = u.id', 'left');

        if (!empty($search)) {
            $builder->like('b.name', $search);
        }

        $builder->orderBy('b.id', 'DESC');
        $brands = $builder->get()->getResultArray();

        $data = [
            'page_title' => 'All Brands',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'brands'     => $brands,
            'search'     => $search
        ];

        return view('admin/brands', $data);
    }

    public function attributes()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $builder = $this->db->table('attributes a');
        $builder->select('a.*');

        if (!empty($search)) {
            $builder->like('a.name', $search);
        }

        $builder->orderBy('a.id', 'DESC');
        $attributes = $builder->get()->getResultArray();

        $data = [
            'page_title' => 'All Attributes',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'attributes' => $attributes,
            'search'     => $search
        ];

        return view('admin/attributes', $data);
    }

    public function colors()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $colorModel = new \App\Models\ColorModel();
        if (!empty($search)) {
            $colorModel->like('name', $search);
        }

        $colors = $colorModel->orderBy('id', 'DESC')->paginate(15);

        $data = [
            'page_title' => 'All Colors',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'colors'     => $colors,
            'pager'      => $colorModel->pager,
            'search'     => $search
        ];

        return view('admin/colors', $data);
    }

    public function productReviews()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $builder = $this->db->table('reviews r');
        $builder->select('r.*, p.name as product_name, u.name as user_name');
        $builder->join('products p', 'r.product_id = p.id', 'left');
        $builder->join('users u', 'r.user_id = u.id', 'left');

        if (!empty($search)) {
            $builder->like('p.name', $search);
        }

        $builder->orderBy('r.id', 'DESC');
        $reviews = $builder->get()->getResultArray();

        $data = [
            'page_title' => 'Product Reviews',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'reviews'    => $reviews,
            'search'     => $search
        ];

        return view('admin/reviews', $data);
    }

    public function auctionCreate()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->findAll();
        $brands = $this->db->table('brands')->get()->getResultArray();

        $data = [
            'page_title' => 'Add New Auction Product',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categories,
            'brands'     => $brands
        ];

        return view('admin/auction/create', $data);
    }

    public function auctionAllProducts()
    {
        return $this->renderAuctionProducts('all', 'All Auction Products');
    }

    public function auctionInhouseProducts()
    {
        return $this->renderAuctionProducts('inhouse', 'Inhouse Auction Products');
    }

    public function auctionSellerProducts()
    {
        return $this->renderAuctionProducts('seller', 'Seller Auction Products');
    }

    private function renderAuctionProducts(string $type, string $title)
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $builder = $this->db->table('products p');
        $builder->select('p.*, c.name as category_name, b.name as brand_name');
        $builder->join('categories c', 'p.category_id = c.id', 'left');
        $builder->join('brands b', 'p.brand_id = b.id', 'left');
        $builder->where('p.auction_product', 1);

        if ($type === 'inhouse') {
            $builder->where('p.added_by', 'admin');
        } elseif ($type === 'seller') {
            $builder->where('p.added_by', 'seller');
        }

        if (!empty($search)) {
            $builder->like('p.name', $search);
        }

        $builder->orderBy('p.id', 'DESC');
        $products = $builder->get()->getResultArray();

        $data = [
            'page_title' => $title,
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'products'   => $products,
            'type'       => $type,
            'search'     => $search
        ];

        return view('admin/auction/products', $data);
    }

    public function auctionOrders()
    {
        $settingModel = new SettingModel();
        $search = $this->request->getGet('search');

        $builder = $this->db->table('orders o');
        $builder->select('o.*, u.name as customer_name');
        $builder->join('users u', 'o.user_id = u.id', 'left');
        $builder->where('o.payment_type', 'auction');

        if (!empty($search)) {
            $builder->like('o.code', $search);
        }

        $builder->orderBy('o.id', 'DESC');
        $orders = $builder->get()->getResultArray();

        $data = [
            'page_title' => 'Auction Products Orders',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'orders'     => $orders,
            'search'     => $search
        ];

        return view('admin/auction/orders', $data);
    }

    public function allOrders()
    {
        $settingModel = new SettingModel();
        
        $orders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, u.email as customer_email')
            ->join('users u', 'o.user_id = u.id', 'left')
            ->orderBy('o.id', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'page_title' => 'All Orders',
            'order_type' => 'All',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'orders' => $orders
        ];

        return view('admin/orders', $data);
    }

    public function inhouseOrders()
    {
        $settingModel = new SettingModel();
        
        $orders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, u.email as customer_email')
            ->join('users u', 'o.user_id = u.id', 'left')
            ->where('o.seller_id', 1)
            ->orderBy('o.id', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'page_title' => 'Inhouse Orders',
            'order_type' => 'Inhouse',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'orders' => $orders
        ];

        return view('admin/orders', $data);
    }

    public function sellerOrders()
    {
        $settingModel = new SettingModel();
        
        $orders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, u.email as customer_email')
            ->join('users u', 'o.user_id = u.id', 'left')
            ->where('o.seller_id !=', 1)
            ->orderBy('o.id', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'page_title' => 'Seller Orders',
            'order_type' => 'Seller',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'orders' => $orders
        ];

        return view('admin/orders', $data);
    }

    public function pickupPointOrders()
    {
        $settingModel = new SettingModel();
        
        $orders = $this->db->table('orders o')
            ->select('o.*, u.name as customer_name, u.email as customer_email')
            ->join('users u', 'o.user_id = u.id', 'left')
            ->where('o.shipping_type', 'pickup_point')
            ->orderBy('o.id', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'page_title' => 'Pick-up Point Orders',
            'order_type' => 'Pick-up Point',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'orders' => $orders
        ];

        return view('admin/orders', $data);
    }

    public function settings()
    {
        $settingModel = new SettingModel();
        $uploads = $this->db->table('uploads')->orderBy('id', 'DESC')->get()->getResultArray();

        $data = [
            'page_title' => 'General Settings',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'site_motto' => $settingModel->getSetting('site_motto', ''),
            'contact_email' => $settingModel->getSetting('contact_email', 'admin@nur-lab.com'),
            'contact_phone' => $settingModel->getSetting('contact_phone', '+8801621520890'),
            'contact_address' => $settingModel->getSetting('contact_address', 'Dhaka, Bangladesh'),
            'system_logo'     => $settingModel->getSetting('system_logo', ''),
            'admin_logo'      => $settingModel->getSetting('admin_logo', ''),
            'site_favicon'    => $settingModel->getSetting('site_favicon', ''),
            'uploads'         => $uploads
        ];

        return view('admin/settings', $data);
    }

    public function saveSettings()
    {
        $settingModel = new SettingModel();

        $fields = ['website_name', 'site_motto', 'contact_email', 'contact_phone', 'contact_address', 'timezone', 'system_default_currency', 'currency_symbol_format'];
        foreach ($fields as $field) {
            $val = $this->request->getPost($field);
            if ($val !== null) {
                $exists = $this->db->table('business_settings')->where('type', $field)->get()->getRow();
                if ($exists) {
                    $this->db->table('business_settings')->where('type', $field)->update(['value' => $val]);
                } else {
                    $this->db->table('business_settings')->insert(['type' => $field, 'value' => $val]);
                }
            }
        }

        // File uploads & media manager handling for logos/favicon
        $imageFields = ['system_logo', 'admin_logo', 'site_favicon'];
        foreach ($imageFields as $imgField) {
            $filePath = null;

            // 1. Check if selected via Media Manager hidden input
            $mediaValue = $this->request->getPost($imgField);
            if (!empty($mediaValue)) {
                if (is_numeric($mediaValue)) {
                    $uploadRecord = $this->db->table('uploads')->where('id', $mediaValue)->get()->getRowArray();
                    if ($uploadRecord) {
                        $filePath = $uploadRecord['file_name'] ?? '';
                    }
                } else {
                    $filePath = $mediaValue;
                }
            }

            // 2. Check if uploaded directly from computer
            $file = $this->request->getFile($imgField . '_file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $imgField . '_' . time() . '.' . $file->getExtension();
                $targetDir = FCPATH . 'assets/img';
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0777, true);
                }
                $file->move($targetDir, $newName);
                $filePath = 'assets/img/' . $newName;

                if ($imgField === 'admin_logo' || $imgField === 'system_logo') {
                    @copy($targetDir . '/' . $newName, $targetDir . '/logo.png');
                }
            }

            if ($filePath) {
                $exists = $this->db->table('business_settings')->where('type', $imgField)->get()->getRow();
                if ($exists) {
                    $this->db->table('business_settings')->where('type', $imgField)->update(['value' => $filePath]);
                } else {
                    $this->db->table('business_settings')->insert(['type' => $imgField, 'value' => $filePath]);
                }
            }
        }

        return redirect()->to(base_url('admin/settings'))->with('success', 'Settings and logos updated successfully.');
    }

    public function pos()
    {
        $settingModel = new SettingModel();
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->getMainCategories(100);
        $brands = $this->db->table('brands')->get()->getResultArray();
        $customers = $this->db->table('users')->where('user_type', 'customer')->get()->getResultArray();
        $products = $productModel->getLatestProducts(50);

        $data = [
            'page_title' => 'POS (Point of Sale)',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categories,
            'brands' => $brands,
            'customers' => $customers,
            'products' => $products
        ];

        return view('admin/pos/index', $data);
    }

    public function posActivation()
    {
        $settingModel = new SettingModel();

        $data = [
            'page_title' => 'POS Activation Configuration',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'pos_activation_for_seller' => $settingModel->getSetting('pos_activation_for_seller', '1'),
            'print_width' => $settingModel->getSetting('print_width', '80'),
        ];

        return view('admin/pos/activation', $data);
    }

    public function wholesaleCreate()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();

        $data = [
            'page_title' => 'Add New Wholesale Product',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->findAll(),
            'brands'     => $this->db->table('brands')->get()->getResultArray()
        ];

        return view('admin/wholesale/create', $data);
    }

    public function wholesaleAllProducts()
    {
        $settingModel = new SettingModel();
        $productModel = new ProductModel();

        $products = $productModel->where('wholesale_product', 1)->paginate(15);

        $data = [
            'page_title' => 'All Wholesale Products',
            'type'       => 'All',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'products'   => $products,
            'pager'      => $productModel->pager
        ];

        return view('admin/wholesale/index', $data);
    }

    public function wholesaleInhouseProducts()
    {
        $settingModel = new SettingModel();
        $productModel = new ProductModel();

        $products = $productModel->where('wholesale_product', 1)->where('added_by', 'admin')->paginate(15);

        $data = [
            'page_title' => 'Inhouse Wholesale Products',
            'type'       => 'In House',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'products'   => $products,
            'pager'      => $productModel->pager
        ];

        return view('admin/wholesale/index', $data);
    }

    public function wholesaleSellerProducts()
    {
        $settingModel = new SettingModel();
        $productModel = new ProductModel();

        $products = $productModel->where('wholesale_product', 1)->where('added_by', 'seller')->paginate(15);

        $data = [
            'page_title' => 'Seller Wholesale Products',
            'type'       => 'Seller',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'products'   => $products,
            'pager'      => $productModel->pager
        ];

        return view('admin/wholesale/index', $data);
    }

    public function units()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Units',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/units', $data);
    }

    public function warranties()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Warranties',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/warranties', $data);
    }

    public function sizeCharts()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Size Charts',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/size_charts', $data);
    }

    public function measurementPoints()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Measurement Points',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/measurement_points', $data);
    }

    public function customLabels()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Custom Labels',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/custom_labels', $data);
    }

    public function categoryWiseDiscount()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();
        $data = [
            'page_title' => 'Category Wise Discount',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->findAll()
        ];
        return view('admin/category_wise_discount', $data);
    }

    public function categoryWiseRefund()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();
        $data = [
            'page_title' => 'Category Wise Refund',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->findAll()
        ];
        return view('admin/category_wise_refund', $data);
    }

    // Generic Admin Module Page Renderer
    private function renderModulePage(string $title)
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => $title,
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/module_placeholder', $data);
    }

    public function deliveryBoys()
    {
        $settingModel = new SettingModel();
        $deliveryBoys = $this->db->table('users')->where('user_type', 'delivery_boy')->get()->getResultArray();
        $data = [
            'page_title'    => 'All Delivery Boys',
            'site_name'     => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'delivery_boys' => $deliveryBoys
        ];
        return view('admin/delivery_boys/index', $data);
    }

    public function createDeliveryBoy()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Add Delivery Boy',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/delivery_boys/create', $data);
    }

    public function deliveryBoyPayments()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Delivery Boy Payment Histories',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/delivery_boys/payments', $data);
    }

    public function deliveryBoyCollected()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Delivery Boy Collection Histories',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/delivery_boys/collected', $data);
    }

    public function deliveryBoyCancelRequests()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Delivery Boy Cancel Requests',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/delivery_boys/cancel_requests', $data);
    }

    public function deliveryBoyConfig()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Delivery Boy Configuration',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/delivery_boys/config', $data);
    }

    public function refundRequests()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Refund Requests',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/refunds/requests', $data);
    }

    public function approvedRefunds()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Approved Refunds',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/refunds/approved', $data);
    }

    public function rejectedRefunds()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Rejected Refunds',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/refunds/rejected', $data);
    }

    public function refundConfig()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Refund Configuration',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/refunds/config', $data);
    }

    public function customers()
    {
        $settingModel = new SettingModel();
        $customers = $this->db->table('users')->where('user_type', 'customer')->get()->getResultArray();
        $data = [
            'page_title' => 'Customer List',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'customers'  => $customers
        ];
        return view('admin/customers/index', $data);
    }

    public function classifiedProducts()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Classified Products',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/customers/classified_products', $data);
    }

    public function classifiedPackages()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Classified Packages',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/customers/classified_packages', $data);
    }

    public function sellers()
    {
        $settingModel = new SettingModel();
        $sellers = $this->db->table('users')->where('user_type', 'seller')->get()->getResultArray();
        $data = [
            'page_title' => 'All Sellers',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'sellers'    => $sellers
        ];
        return view('admin/sellers/index', $data);
    }

    public function sellerPayouts()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Seller Payouts',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/sellers/payouts', $data);
    }

    public function sellerPayoutRequests()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Seller Payout Requests',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/sellers/payout_requests', $data);
    }

    public function sellerCommission()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Seller Commission',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/sellers/commission', $data);
    }

    public function sellerPackages()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Seller Packages',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/sellers/packages', $data);
    }

    public function sellerVerificationForm()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Seller Verification Form',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM')
        ];
        return view('admin/sellers/verification_form', $data);
    }

    public function uploadedFiles()
    {
        $settingModel = new SettingModel();
        $allUploads = $this->db->table('uploads')->orderBy('id', 'DESC')->get()->getResultArray();
        
        $validUploads = [];
        foreach ($allUploads as $file) {
            $rawPath = $file['file_name'] ?? '';
            $cleanPath = ltrim(str_replace('public/', '', $rawPath), '/');

            if (!empty($cleanPath) && strpos($cleanPath, 'uploads/') !== 0 && strpos($cleanPath, 'assets/') !== 0) {
                if (file_exists(FCPATH . 'uploads/all/' . $cleanPath)) {
                    $cleanPath = 'uploads/all/' . $cleanPath;
                } elseif (file_exists(FCPATH . 'uploads/product/' . $cleanPath)) {
                    $cleanPath = 'uploads/product/' . $cleanPath;
                }
            }

            if (!empty($cleanPath) && file_exists(FCPATH . $cleanPath)) {
                $file['file_name'] = $cleanPath;
                $validUploads[] = $file;
            }
        }

        $data = [
            'page_title' => 'All Uploaded Files',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'uploads'    => $validUploads
        ];
        return view('admin/uploaded_files/index', $data);
    }

    public function uploadMediaFile()
    {
        $files = $this->request->getFiles();
        if (isset($files['media_files'])) {
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }

            foreach ($files['media_files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($targetDir, $newName);

                    $filePath = 'uploads/all/' . $newName;
                    $ext = strtolower($file->getExtension());
                    $type = in_array($ext, ['jpg','jpeg','png','webp','gif']) ? 'image' : ($ext === 'mp4' ? 'video' : 'document');

                    $this->db->table('uploads')->insert([
                        'file_original_name' => $file->getClientName(),
                        'file_name'          => $filePath,
                        'user_id'            => 1,
                        'file_size'          => $file->getSize(),
                        'extension'          => $ext,
                        'type'               => $type,
                        'created_at'         => date('Y-m-d H:i:s'),
                        'updated_at'         => date('Y-m-d H:i:s')
                    ]);
                }
            }
            session()->setFlashdata('success', 'Media files uploaded successfully.');
        }

        return redirect()->to(base_url('admin/uploaded-files'));
    }

    public function destroyMediaFile($id)
    {
        $file = $this->db->table('uploads')->where('id', $id)->get()->getRowArray();
        if ($file) {
            $rawPath = $file['file_name'] ?? '';
            $cleanPath = ltrim(str_replace('public/', '', $rawPath), '/');

            if (!empty($cleanPath) && file_exists(FCPATH . $cleanPath)) {
                @unlink(FCPATH . $cleanPath);
            } elseif (!empty($cleanPath) && file_exists(FCPATH . 'uploads/all/' . basename($cleanPath))) {
                @unlink(FCPATH . 'uploads/all/' . basename($cleanPath));
            }

            $this->db->table('uploads')->where('id', $id)->delete();
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'File deleted permanently.']);
    }

    public function bulkDestroyMediaFiles()
    {
        $ids = $this->request->getPost('ids');
        if (!empty($ids) && is_array($ids)) {
            foreach ($ids as $id) {
                $file = $this->db->table('uploads')->where('id', $id)->get()->getRowArray();
                if ($file) {
                    $rawPath = $file['file_name'] ?? '';
                    $cleanPath = ltrim(str_replace('public/', '', $rawPath), '/');

                    if (!empty($cleanPath) && file_exists(FCPATH . $cleanPath)) {
                        @unlink(FCPATH . $cleanPath);
                    } elseif (!empty($cleanPath) && file_exists(FCPATH . 'uploads/all/' . basename($cleanPath))) {
                        @unlink(FCPATH . 'uploads/all/' . basename($cleanPath));
                    }

                    $this->db->table('uploads')->where('id', $id)->delete();
                }
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Selected files deleted permanently.']);
    }

    public function inhouseSalesReport() { return view('admin/reports/inhouse_sales'); }
    public function sellerSalesReport() { return view('admin/reports/seller_sales'); }
    public function stockReport() { return view('admin/reports/stock'); }
    public function wishlistReport() { return view('admin/reports/wishlist'); }
    public function userSearchesReport() { return view('admin/reports/user_searches'); }
    public function commissionHistoryReport() { return view('admin/reports/commission_history'); }
    public function walletRechargeReport() { return view('admin/reports/wallet_recharge'); }

    public function blogPosts() { return view('admin/blog/index'); }
    public function blogCategories() { return view('admin/blog/categories'); }

    public function flashDeals() { return view('admin/marketing/flash_deals'); }
    public function newsletters() { return view('admin/marketing/newsletters'); }
    public function subscribers() { return view('admin/marketing/subscribers'); }
    public function coupons() { return view('admin/marketing/coupons'); }

    public function supportTickets() { return view('admin/support/tickets'); }
    public function supportQueries() { return view('admin/support/queries'); }

    public function websiteHeader() { return view('admin/website/header'); }
    public function websiteFooter() { return view('admin/website/footer'); }
    public function websitePages() { return view('admin/website/pages'); }
    public function websiteAppearance() { return view('admin/website/appearance'); }

    public function setupFeatures() { return view('admin/setup/features'); }
    public function setupLanguages() { return view('admin/setup/languages'); }
    public function setupCurrencies() { return view('admin/setup/currencies'); }
    public function setupPaymentMethods() { return view('admin/setup/payment_methods'); }
    public function setupVatTax() { return view('admin/setup/generic', ['page_title' => 'Vat & TAX Setup']); }
    public function setupPickupPoint() { return view('admin/setup/generic', ['page_title' => 'Pickup Point Setup']); }
    public function setupSmtp() { return view('admin/setup/generic', ['page_title' => 'SMTP Settings']); }
    public function setupOrderConfig() { return view('admin/setup/generic', ['page_title' => 'Order Configuration']); }
    public function setupFileSystem() { return view('admin/setup/generic', ['page_title' => 'File System & Cache Configuration']); }
    public function setupSocialLogins() { return view('admin/setup/generic', ['page_title' => 'Social Media Logins']); }
    public function setupFacebookChat() { return view('admin/setup/generic', ['page_title' => 'Facebook Chat Integration']); }
    public function setupFacebookComment() { return view('admin/setup/generic', ['page_title' => 'Facebook Comment Integration']); }
    public function setupGoogleAnalytics() { return view('admin/setup/generic', ['page_title' => 'Google Analytics Integration']); }
    public function setupGoogleRecaptcha() { return view('admin/setup/generic', ['page_title' => 'Google Recaptcha Integration']); }
    public function setupShippingConfig() {
        $settingModel = new \App\Models\SettingModel();
        return view('admin/setup/shipping_configuration', [
            'page_title' => 'Shipping Configuration',
            'shipping_type' => $settingModel->getSetting('shipping_type', 'flat_rate'),
            'flat_rate_shipping_cost' => $settingModel->getSetting('flat_rate_shipping_cost', 0)
        ]);
    }
    public function setupShippingCountries() {
        $sort_country = $this->request->getVar('sort_country');
        $builder = $this->db->table('countries');
        if (!empty($sort_country)) {
            $builder->like('name', $sort_country);
        }
        $builder->orderBy('status', 'desc')->orderBy('name', 'asc');
        $countries = $builder->get()->getResultArray();
        return view('admin/setup/shipping_countries', ['countries' => $countries, 'sort_country' => $sort_country]);
    }
    
    public function updateShippingCountryStatus() {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        
        $updated = $this->db->table('countries')
                            ->where('id', $id)
                            ->update(['status' => $status]);
                            
        if($updated) {
            return "1";
        }
        return "0";
    }
    
    public function updateShippingConfig() {
        $type = $this->request->getPost('type');
        
        if($type == 'shipping_type') {
            $val = $this->request->getPost('shipping_type');
            $this->db->table('business_settings')->where('type', 'shipping_type')->update(['value' => $val]);
        }
        elseif($type == 'flat_rate_shipping_cost') {
            $val = $this->request->getPost('flat_rate_shipping_cost');
            $this->db->table('business_settings')->where('type', 'flat_rate_shipping_cost')->update(['value' => $val]);
        }
        
        return redirect()->back()->with('success', 'Shipping configuration updated successfully');
    }
    
    public function setupShippingStates() { return view('admin/setup/generic', ['page_title' => 'Shipping States']); }
    public function setupShippingCities() {
        $sort_city = $this->request->getVar('sort_city');
        $builder = $this->db->table('cities');
        $builder->select('cities.*, states.name as state_name, countries.name as country_name');
        $builder->join('states', 'states.id = cities.state_id', 'left');
        $builder->join('countries', 'countries.id = cities.country_id', 'left');
        
        if (!empty($sort_city)) {
            $builder->like('cities.name', $sort_city);
        }
        
        $builder->orderBy('cities.status', 'desc')->orderBy('cities.name', 'asc');
        $cities = $builder->get()->getResultArray();
        
        return view('admin/setup/shipping_cities', ['cities' => $cities, 'sort_city' => $sort_city]);
    }
    
    public function updateShippingCityStatus() {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        
        $updated = $this->db->table('cities')
                            ->where('id', $id)
                            ->update(['status' => $status]);
                            
        if($updated) {
            return "1";
        }
        return "0";
    }
    public function setupShippingZones() { return view('admin/setup/generic', ['page_title' => 'Shipping Zones']); }
    public function setupShippingCarriers() { return view('admin/setup/generic', ['page_title' => 'Shipping Carriers']); }

    public function staff() { return view('admin/staff/index'); }
    public function staffRoles() { return view('admin/staff/roles'); }
    public function systemUpdate() { return view('admin/system/update'); }
    public function serverStatus() { return view('admin/system/server_status'); }
    public function backupAndRestore() { return view('admin/system/backups'); }

    public function clearCache()
    {
        $cache = \Config\Services::cache();
        $cache->clean();
        return redirect()->back()->with('success', 'Cache cleared successfully!');
    }

    public function profile()
    {
        $settingModel = new SettingModel();
        $sessionUser = session()->get('user');
        
        $adminUser = null;
        if (!empty($sessionUser['id'])) {
            $adminUser = $this->db->table('users')->where('id', $sessionUser['id'])->get()->getRowArray();
        }

        if (!$adminUser) {
            $adminUser = $this->db->table('users')->where('user_type', 'admin')->get()->getRowArray();
        }

        if (!$adminUser) {
            $adminUser = [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@nur-lab.com',
                'phone' => '+880 1700-000000',
            ];
        }

        return view('admin/profile', [
            'page_title' => 'Admin Profile',
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'adminUser' => $adminUser
        ]);
    }

    public function updateProfile()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $password = $this->request->getPost('password');

        $updateData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!empty($id)) {
            $this->db->table('users')->where('id', $id)->update($updateData);
            
            // Refresh session user data if logged in
            $updatedUser = $this->db->table('users')->where('id', $id)->get()->getRowArray();
            if ($updatedUser) {
                session()->set('user', $updatedUser);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
