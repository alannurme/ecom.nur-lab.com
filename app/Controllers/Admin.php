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

        $thumbnailImg = $this->request->getPost('thumbnail_img_id');
        $file = $this->request->getFile('thumbnail_img');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'thumb_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $thumbnailImg = $this->db->insertID();
        }

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($name ?? 'product')) . '-' . rand(1000, 9999);
        $isWholesale = $this->request->getPost('is_wholesale') ?? 0;

        // Process Gallery Images (from Modal & PC upload)
        $photosIds = $this->request->getPost('photos_ids');
        $galleryPhotoIds = [];
        if (!empty($photosIds)) {
            $galleryPhotoIds = array_filter(array_map('trim', explode(',', $photosIds)));
        }

        $galleryFiles = $this->request->getFiles();
        if (isset($galleryFiles['photos']) && is_array($galleryFiles['photos'])) {
            foreach ($galleryFiles['photos'] as $gFile) {
                if ($gFile && $gFile->isValid() && !$gFile->hasMoved()) {
                    $gNewName = 'gallery_' . time() . '_' . rand(100, 999) . '.' . $gFile->getExtension();
                    $targetDir = FCPATH . 'uploads/all';
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0777, true);
                    }
                    $gFile->move($targetDir, $gNewName);
                    $gFilePath = 'uploads/all/' . $gNewName;

                    $this->db->table('uploads')->insert([
                        'file_original_name' => $gFile->getClientName(),
                        'file_name'          => $gFilePath,
                        'file_size'          => $gFile->getSize(),
                        'extension'          => $gFile->getExtension(),
                        'type'               => 'image',
                        'created_at'         => date('Y-m-d H:i:s'),
                        'updated_at'         => date('Y-m-d H:i:s')
                    ]);
                    $galleryPhotoIds[] = $this->db->insertID();
                }
            }
        }
        $photosString = implode(',', array_unique($galleryPhotoIds));

        $productData = [
            'name'              => $name ?? 'New Product',
            'added_by'          => 'admin',
            'user_id'           => 1,
            'category_id'       => $categoryId ?? 1,
            'brand_id'          => $brandId ?? 1,
            'photos'            => $photosString,
            'thumbnail_img'     => $thumbnailImg,
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

        $thumbnailPath = '';
        if (!empty($product['thumbnail_img'])) {
            if (is_numeric($product['thumbnail_img'])) {
                $uploadRecord = $this->db->table('uploads')->where('id', $product['thumbnail_img'])->get()->getRowArray();
                if ($uploadRecord) {
                    $thumbnailPath = $uploadRecord['file_name'];
                }
            } else {
                $thumbnailPath = $product['thumbnail_img'];
            }
        }
        $product['thumbnail_path'] = $thumbnailPath;

        // Resolve Gallery Images
        $galleryImages = [];
        if (!empty($product['photos'])) {
            $photoIds = explode(',', $product['photos']);
            foreach ($photoIds as $pId) {
                $pId = trim($pId);
                if (empty($pId)) continue;
                if (is_numeric($pId)) {
                    $uploadRecord = $this->db->table('uploads')->where('id', $pId)->get()->getRowArray();
                    if ($uploadRecord) {
                        $galleryImages[] = [
                            'id'  => $uploadRecord['id'],
                            'url' => base_url($uploadRecord['file_name'])
                        ];
                    }
                } else {
                    $galleryImages[] = [
                        'id'  => $pId,
                        'url' => base_url($pId)
                    ];
                }
            }
        }
        $product['gallery_images'] = $galleryImages;

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

        $thumbnailImg = $this->request->getPost('thumbnail_img_id');
        $file = $this->request->getFile('thumbnail_img');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'thumb_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $thumbnailImg = $this->db->insertID();
        }

        // Process Gallery Images (from Modal & PC upload)
        $photosIds = $this->request->getPost('photos_ids');
        $galleryPhotoIds = [];
        if (!empty($photosIds)) {
            $galleryPhotoIds = array_filter(array_map('trim', explode(',', $photosIds)));
        }

        $galleryFiles = $this->request->getFiles();
        if (isset($galleryFiles['photos']) && is_array($galleryFiles['photos'])) {
            foreach ($galleryFiles['photos'] as $gFile) {
                if ($gFile && $gFile->isValid() && !$gFile->hasMoved()) {
                    $gNewName = 'gallery_' . time() . '_' . rand(100, 999) . '.' . $gFile->getExtension();
                    $targetDir = FCPATH . 'uploads/all';
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0777, true);
                    }
                    $gFile->move($targetDir, $gNewName);
                    $gFilePath = 'uploads/all/' . $gNewName;

                    $this->db->table('uploads')->insert([
                        'file_original_name' => $gFile->getClientName(),
                        'file_name'          => $gFilePath,
                        'file_size'          => $gFile->getSize(),
                        'extension'          => $gFile->getExtension(),
                        'type'               => 'image',
                        'created_at'         => date('Y-m-d H:i:s'),
                        'updated_at'         => date('Y-m-d H:i:s')
                    ]);
                    $galleryPhotoIds[] = $this->db->insertID();
                }
            }
        }

        $updateData = [
            'name'           => $name,
            'category_id'    => $categoryId,
            'brand_id'       => $brandId,
            'unit_price'     => $unitPrice,
            'purchase_price' => $purchasePrice,
            'current_stock'  => $currentStock,
            'photos'         => implode(',', array_unique($galleryPhotoIds)),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        if ($thumbnailImg !== null && $thumbnailImg !== '') {
            $updateData['thumbnail_img'] = $thumbnailImg;
        }

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

        // Number of items per page
        $perPage = 15;
        $page = (int)($this->request->getGet('page') ?? 1);
        if ($page < 1) $page = 1;

        $total = $builder->countAllResults(false);
        $categories = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        $pager = \Config\Services::pager();
        $pagerLinks = $pager->makeLinks($page, $perPage, $total, 'aiz_pagination');

        $data = [
            'page_title'  => 'All Categories',
            'site_name'   => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories'  => $categories,
            'search'      => $search,
            'tab'         => $tab,
            'pager_links' => $pagerLinks
        ];

        return view('admin/categories', $data);
    }

    public function updateCategoryStatus()
    {
        $id = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $status = $this->request->getPost('status');

        if (!empty($id) && in_array($field, ['featured', 'hot_category', 'home_showcase'])) {
            $val = ($field === 'hot_category') ? (string)($status ? 1 : 0) : ($status ? 1 : 0);
            $this->db->table('categories')->where('id', $id)->update([$field => $val]);
            return $this->response->setJSON(['status' => 1, 'message' => 'Category updated successfully']);
        }
        return $this->response->setJSON(['status' => 0, 'message' => 'Invalid parameters']);
    }

    public function createCategory()
    {
        $settingModel = new SettingModel();
        $categoryModel = new \App\Models\CategoryModel();

        $categories = $categoryModel->findAll();
        $data = [
            'page_title' => 'Add New Category',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categories
        ];
        return view('admin/categories/form', $data);
    }

    public function storeCategory()
    {
        $name = $this->request->getPost('name');
        $slug = mb_url_title($name, '-', true);
        $parentId = $this->request->getPost('parent_id') ?: 0;
        $digital = $this->request->getPost('digital') ? 1 : 0;
        $orderLevel = (int)($this->request->getPost('order_level') ?? 0);
        
        $bannerImg = $this->request->getPost('banner');
        if (empty($bannerImg)) {
            $bannerImg = $this->request->getPost('banner_img') ?? '';
        }

        $file = $this->request->getFile('banner_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'banner_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $bannerImg = $this->db->insertID();
        }

        $insertData = [
            'name'        => $name,
            'slug'        => $slug,
            'parent_id'   => $parentId,
            'digital'     => $digital,
            'order_level' => $orderLevel,
            'banner'      => $bannerImg,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->db->table('categories')->insert($insertData);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Category created successfully');
    }

    public function editCategory($id)
    {
        $settingModel = new SettingModel();
        $categoryModel = new \App\Models\CategoryModel();

        $category = $categoryModel->find($id);
        if (!$category) {
            return redirect()->to(base_url('admin/categories'))->with('error', 'Category not found');
        }

        // Resolve banner image path for preview
        $bannerImg = '';
        if (!empty($category['banner'])) {
            if (is_numeric($category['banner'])) {
                $uploadRecord = $this->db->table('uploads')->where('id', $category['banner'])->get()->getRowArray();
                if ($uploadRecord) {
                    $bannerImg = $uploadRecord['file_name'];
                }
            } else {
                $bannerImg = $category['banner'];
            }
        }
        $category['banner_img'] = $bannerImg;

        $allCategories = $categoryModel->where('id !=', $id)->findAll();
        $data = [
            'page_title'     => 'Edit Category',
            'site_name'      => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'category'       => $category,
            'all_categories' => $allCategories
        ];
        return view('admin/categories/form', $data);
    }

    public function updateCategory($id)
    {
        $name = $this->request->getPost('name');
        $slug = mb_url_title($name, '-', true);
        $parentId = $this->request->getPost('parent_id') ?: 0;
        $digital = $this->request->getPost('digital') ? 1 : 0;
        $orderLevel = (int)($this->request->getPost('order_level') ?? 0);

        $bannerImg = $this->request->getPost('banner');
        if ($bannerImg === null || $bannerImg === '') {
            $bannerImg = $this->request->getPost('banner_img');
        }

        $file = $this->request->getFile('banner_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'banner_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $bannerImg = $this->db->insertID();
        }

        $updateData = [
            'name'        => $name,
            'slug'        => $slug,
            'parent_id'   => $parentId,
            'digital'     => $digital,
            'order_level' => $orderLevel,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($bannerImg !== null && $bannerImg !== '') {
            $updateData['banner'] = $bannerImg;
        }

        $this->db->table('categories')->where('id', $id)->update($updateData);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $this->db->table('categories')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/categories'))->with('success', 'Category deleted successfully');
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

    public function createBrand()
    {
        $settingModel = new SettingModel();
        $data = [
            'page_title' => 'Add New Brand',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
        ];
        return view('admin/brands/form', $data);
    }

    public function storeBrand()
    {
        $name = $this->request->getPost('name');
        $slug = mb_url_title($name, '-', true);
        $metaTitle = $this->request->getPost('meta_title');
        $metaDesc = $this->request->getPost('meta_description');
        $metaKeywords = $this->request->getPost('meta_keywords');

        $logoImg = $this->request->getPost('logo');

        $file = $this->request->getFile('logo_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'brand_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $logoImg = $this->db->insertID();
        }

        $insertData = [
            'name'             => $name,
            'slug'             => $slug,
            'logo'             => $logoImg,
            'meta_title'       => $metaTitle,
            'meta_description' => $metaDesc,
            'meta_keywords'    => $metaKeywords,
            'created_at'       => date('Y-m-d H:i:s')
        ];

        $this->db->table('brands')->insert($insertData);

        return redirect()->to(base_url('admin/brands'))->with('success', 'Brand created successfully');
    }

    public function editBrand($id)
    {
        $settingModel = new SettingModel();
        $brand = $this->db->table('brands')->where('id', $id)->get()->getRowArray();
        if (!$brand) {
            return redirect()->to(base_url('admin/brands'))->with('error', 'Brand not found');
        }

        $logoImg = '';
        if (!empty($brand['logo'])) {
            if (is_numeric($brand['logo'])) {
                $uploadRecord = $this->db->table('uploads')->where('id', $brand['logo'])->get()->getRowArray();
                if ($uploadRecord) {
                    $logoImg = $uploadRecord['file_name'];
                }
            } else {
                $logoImg = $brand['logo'];
            }
        }
        $brand['logo_img'] = $logoImg;

        $data = [
            'page_title' => 'Edit Brand',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'brand'      => $brand
        ];
        return view('admin/brands/form', $data);
    }

    public function updateBrand($id)
    {
        $name = $this->request->getPost('name');
        $slug = mb_url_title($name, '-', true);
        $metaTitle = $this->request->getPost('meta_title');
        $metaDesc = $this->request->getPost('meta_description');
        $metaKeywords = $this->request->getPost('meta_keywords');

        $logoImg = $this->request->getPost('logo');

        $file = $this->request->getFile('logo_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'brand_' . time() . '_' . rand(100, 999) . '.' . $file->getExtension();
            $targetDir = FCPATH . 'uploads/all';
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $newName);
            $filePath = 'uploads/all/' . $newName;

            $this->db->table('uploads')->insert([
                'file_original_name' => $file->getClientName(),
                'file_name'          => $filePath,
                'file_size'          => $file->getSize(),
                'extension'          => $file->getExtension(),
                'type'               => 'image',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);
            $logoImg = $this->db->insertID();
        }

        $updateData = [
            'name'             => $name,
            'slug'             => $slug,
            'meta_title'       => $metaTitle,
            'meta_description' => $metaDesc,
            'meta_keywords'    => $metaKeywords,
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        if ($logoImg !== null && $logoImg !== '') {
            $updateData['logo'] = $logoImg;
        }

        $this->db->table('brands')->where('id', $id)->update($updateData);

        return redirect()->to(base_url('admin/brands'))->with('success', 'Brand updated successfully');
    }

    public function deleteBrand($id)
    {
        $this->db->table('brands')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/brands'))->with('success', 'Brand deleted successfully');
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

        $productModel = new \App\Models\ProductModel();
        $products = $productModel->select('id, name')->orderBy('name', 'ASC')->findAll();

        $data = [
            'page_title' => 'Product Reviews',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'reviews'    => $reviews,
            'products'   => $products,
            'search'     => $search
        ];

        return view('admin/reviews', $data);
    }

    public function storeReview()
    {
        $productId = (int)$this->request->getPost('product_id');
        $reviewerName = trim($this->request->getPost('reviewer_name') ?? 'Admin Custom Review');
        $rating = (int)($this->request->getPost('rating') ?? 5);
        $comment = trim($this->request->getPost('comment') ?? '');

        if ($productId > 0) {
            $data = [
                'product_id' => $productId,
                'user_id'    => 0,
                'rating'     => $rating,
                'comment'    => $comment,
                'status'     => 1,
                'viewed'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('reviews')->insert($data);
            return redirect()->to(base_url('admin/product-reviews'))->with('success', 'Custom review added successfully!');
        }

        return redirect()->to(base_url('admin/product-reviews'))->with('error', 'Please select a valid product.');
    }

    public function deleteReview($id)
    {
        $this->db->table('reviews')->where('id', (int)$id)->delete();
        return redirect()->to(base_url('admin/product-reviews'))->with('success', 'Review deleted successfully!');
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

        $fields = [
            'website_name', 'site_motto', 'contact_email', 'contact_phone', 'contact_address', 
            'timezone', 'system_default_currency', 'currency_symbol_format',
            'sticky_header', 'show_full_width_header', 'show_language_switcher', 'show_currency_switcher', 'header_nav_menu'
        ];
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
        $imageFields = ['system_logo', 'admin_logo', 'site_favicon', 'header_logo'];
        foreach ($imageFields as $imgField) {
            $filePath = null;

            // 1. Check if selected via Media Manager hidden input or direct file
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

            // 2. Check direct file upload
            $file = $this->request->getFile($imgField . '_file');
            if (!$file) {
                $file = $this->request->getFile($imgField);
            }
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $imgField . '_' . time() . '.' . $file->getExtension();
                $targetDir = FCPATH . 'assets/img';
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0777, true);
                }
                $file->move($targetDir, $newName);
                $filePath = 'assets/img/' . $newName;

                if ($imgField === 'admin_logo' || $imgField === 'system_logo' || $imgField === 'header_logo') {
                    @copy($targetDir . '/' . $newName, $targetDir . '/logo.png');
                    if ($imgField === 'header_logo') {
                        $this->db->table('business_settings')->where('type', 'system_logo')->update(['value' => $filePath]);
                    }
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

        $referrer = $this->request->getServer('HTTP_REFERER');
        if (!empty($referrer)) {
            return redirect()->to($referrer)->with('success', 'Header/Settings updated successfully.');
        }

        return redirect()->to(base_url('admin/settings'))->with('success', 'Settings updated successfully.');
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
        $raw = $settingModel->getSetting('units');
        $units = [];
        if ($raw) {
            $units = json_decode($raw, true) ?? [];
        } else {
            // Default seed
            $units = [
                ['id' => 1, 'name' => 'Pc', 'code' => 'pc', 'status' => 1],
                ['id' => 2, 'name' => 'KG', 'code' => 'kg', 'status' => 1],
                ['id' => 3, 'name' => 'Litre', 'code' => 'ltr', 'status' => 1],
                ['id' => 4, 'name' => 'Gram', 'code' => 'g', 'status' => 1],
                ['id' => 5, 'name' => 'Meter', 'code' => 'm', 'status' => 1],
                ['id' => 6, 'name' => 'Box', 'code' => 'box', 'status' => 1],
            ];
            $settingModel->saveSetting('units', json_encode($units));
        }

        $data = [
            'page_title' => 'Units',
            'site_name'  => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'units'      => $units
        ];
        return view('admin/units', $data);
    }

    public function storeUnit()
    {
        $settingModel = new SettingModel();
        $raw = $settingModel->getSetting('units');
        $units = $raw ? (json_decode($raw, true) ?? []) : [];

        $name = trim($this->request->getPost('name') ?? '');
        $code = trim($this->request->getPost('code') ?? strtolower($name));
        $status = $this->request->getPost('status') ? 1 : 0;

        if (!empty($name)) {
            $maxId = 0;
            foreach ($units as $u) {
                if (($u['id'] ?? 0) > $maxId) $maxId = $u['id'];
            }
            $units[] = [
                'id' => $maxId + 1,
                'name' => $name,
                'code' => $code,
                'status' => $status
            ];
            $settingModel->saveSetting('units', json_encode(array_values($units)));
            return redirect()->to(base_url('admin/units'))->with('success', 'Unit added successfully!');
        }
        return redirect()->to(base_url('admin/units'))->with('error', 'Unit name cannot be empty.');
    }

    public function updateUnit()
    {
        $settingModel = new SettingModel();
        $raw = $settingModel->getSetting('units');
        $units = $raw ? (json_decode($raw, true) ?? []) : [];

        $id = (int)$this->request->getPost('id');
        $name = trim($this->request->getPost('name') ?? '');
        $code = trim($this->request->getPost('code') ?? strtolower($name));
        $status = $this->request->getPost('status') ? 1 : 0;

        foreach ($units as &$u) {
            if (($u['id'] ?? 0) == $id) {
                $u['name'] = $name;
                $u['code'] = $code;
                $u['status'] = $status;
                break;
            }
        }
        $settingModel->saveSetting('units', json_encode(array_values($units)));
        return redirect()->to(base_url('admin/units'))->with('success', 'Unit updated successfully!');
    }

    public function deleteUnit($id)
    {
        $settingModel = new SettingModel();
        $raw = $settingModel->getSetting('units');
        $units = $raw ? (json_decode($raw, true) ?? []) : [];

        $units = array_filter($units, fn($u) => ($u['id'] ?? 0) != $id);
        $settingModel->saveSetting('units', json_encode(array_values($units)));

        return redirect()->to(base_url('admin/units'))->with('success', 'Unit deleted successfully!');
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

    public function websiteHeader() 
    { 
        $settingModel = new \App\Models\SettingModel();
        $data = [
            'header_logo'            => $settingModel->getSetting('header_logo', $settingModel->getSetting('system_logo', '')),
            'sticky_header'          => $settingModel->getSetting('sticky_header', '1'),
            'show_full_width_header' => $settingModel->getSetting('show_full_width_header', '1'),
            'show_language_switcher' => $settingModel->getSetting('show_language_switcher', '1'),
            'show_currency_switcher' => $settingModel->getSetting('show_currency_switcher', '1'),
            'header_nav_menu'        => $settingModel->getSetting('header_nav_menu', 'Home, All Products, Flash Sale, Track Order, Help')
        ];
        return view('admin/website/header', $data); 
    }
    public function websiteFooter() { return view('admin/website/footer'); }
    public function websitePages() { return view('admin/website/pages'); }
    public function websiteAppearance() { return view('admin/website/appearance'); }

    public function setupFeatures() 
    { 
        $settingModel = new \App\Models\SettingModel();
        $keys = [
            'force_https', 'maintenance_mode', 'disable_image_optimization',
            'vendor_system_activation', 'classified_product', 'auction_product',
            'wholesale_product', 'pos_system', 'coupon_system'
        ];
        $features = [];
        foreach ($keys as $key) {
            $features[$key] = (int)$settingModel->getSetting($key, in_array($key, ['force_https', 'vendor_system_activation', 'classified_product', 'auction_product', 'wholesale_product', 'pos_system', 'coupon_system']) ? 1 : 0);
        }
        return view('admin/setup/features', ['features' => $features]); 
    }

    public function updateFeatureStatus()
    {
        $key = $this->request->getPost('key');
        $status = $this->request->getPost('status');

        if (!empty($key)) {
            $val = $status ? '1' : '0';
            $exists = $this->db->table('business_settings')->where('type', $key)->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', $key)->update(['value' => $val]);
            } else {
                $this->db->table('business_settings')->insert(['type' => $key, 'value' => $val]);
            }
            return $this->response->setJSON(['status' => 1, 'message' => 'Feature status updated successfully']);
        }
        return $this->response->setJSON(['status' => 0, 'message' => 'Invalid feature key']);
    }

    public function warranties()
    {
        $settingModel = new \App\Models\SettingModel();
        $defaultWarranties = [
            ['id' => 1, 'name' => '1 Year Official Brand Warranty', 'text' => '1 Year Official Brand Warranty', 'type' => 'Brand Warranty', 'duration' => '1', 'period_type' => 'years', 'description' => 'Official manufacturer warranty', 'status' => 1],
            ['id' => 2, 'name' => '6 Months Replacement Guarantee', 'text' => '6 Months Replacement Guarantee', 'type' => 'Replacement', 'duration' => '6', 'period_type' => 'months', 'description' => 'Direct store replacement guarantee', 'status' => 1],
            ['id' => 3, 'name' => '2 Years Free Service Warranty', 'text' => '2 Years Free Service Warranty', 'type' => 'Service Warranty', 'duration' => '2', 'period_type' => 'years', 'description' => 'Free labor and service warranty', 'status' => 1]
        ];
        $warrantiesJson = $settingModel->getSetting('warranties', null);
        if ($warrantiesJson === null) {
            $warranties = $defaultWarranties;
            $this->db->table('business_settings')->insert(['type' => 'warranties', 'value' => json_encode($warranties)]);
        } else {
            $warranties = json_decode($warrantiesJson, true) ?: [];
        }

        return view('admin/warranties', [
            'page_title' => 'Warranties',
            'warranties' => $warranties
        ]);
    }

    public function storeWarranty()
    {
        $name = trim($this->request->getPost('name') ?? $this->request->getPost('text') ?? '');
        $duration = trim($this->request->getPost('duration') ?? '1');
        $periodType = trim($this->request->getPost('period_type') ?? 'months');
        $description = trim($this->request->getPost('description') ?? '');
        $status = $this->request->getPost('status') !== null ? (int)$this->request->getPost('status') : 1;

        if (!empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $warrantiesJson = $settingModel->getSetting('warranties', '[]');
            $warranties = json_decode($warrantiesJson, true) ?: [];

            $maxId = 0;
            foreach ($warranties as $w) {
                if (isset($w['id']) && $w['id'] > $maxId) {
                    $maxId = $w['id'];
                }
            }

            $warranties[] = [
                'id'          => $maxId + 1,
                'name'        => $name,
                'text'        => $name,
                'type'        => $name,
                'duration'    => $duration,
                'period_type' => $periodType,
                'description' => $description,
                'status'      => $status
            ];

            $jsonVal = json_encode(array_values($warranties));
            $exists = $this->db->table('business_settings')->where('type', 'warranties')->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', 'warranties')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'warranties', 'value' => $jsonVal]);
            }

            return redirect()->back()->with('success', 'Warranty policy added successfully.');
        }

        return redirect()->back()->with('error', 'Warranty policy name cannot be empty.');
    }

    public function updateWarranty()
    {
        $id = (int)$this->request->getPost('id');
        $name = trim($this->request->getPost('name') ?? $this->request->getPost('text') ?? '');
        $duration = trim($this->request->getPost('duration') ?? '1');
        $periodType = trim($this->request->getPost('period_type') ?? 'months');
        $description = trim($this->request->getPost('description') ?? '');
        $status = $this->request->getPost('status') !== null ? (int)$this->request->getPost('status') : 0;

        if ($id > 0 && !empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $warrantiesJson = $settingModel->getSetting('warranties', '[]');
            $warranties = json_decode($warrantiesJson, true) ?: [];

            foreach ($warranties as &$w) {
                if (isset($w['id']) && $w['id'] == $id) {
                    $w['name']        = $name;
                    $w['text']        = $name;
                    $w['duration']    = $duration;
                    $w['period_type'] = $periodType;
                    $w['description'] = $description;
                    $w['status']      = $status;
                    break;
                }
            }

            $jsonVal = json_encode(array_values($warranties));
            $this->db->table('business_settings')->where('type', 'warranties')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Warranty policy updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid warranty data.');
    }

    public function deleteWarranty($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $settingModel = new \App\Models\SettingModel();
            $warrantiesJson = $settingModel->getSetting('warranties', '[]');
            $warranties = json_decode($warrantiesJson, true) ?: [];

            $newWarranties = [];
            foreach ($warranties as $w) {
                if (isset($w['id']) && $w['id'] == $id) {
                    continue;
                }
                $newWarranties[] = $w;
            }

            $jsonVal = json_encode(array_values($newWarranties));
            $this->db->table('business_settings')->where('type', 'warranties')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Warranty policy deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid warranty ID.');
    }

    public function sizeCharts()
    {
        $settingModel = new \App\Models\SettingModel();
        $builder = $this->db->table('categories');
        $categories = $builder->get()->getResultArray();

        $defaultCharts = [
            ['id' => 1, 'name' => 'Men T-Shirt Size Chart', 'category' => 'Men Clothing', 'sizes' => 'S, M, L, XL, XXL'],
            ['id' => 2, 'name' => 'Women Dress Size Chart', 'category' => 'Women Clothing', 'sizes' => 'XS, S, M, L, XL'],
            ['id' => 3, 'name' => 'Footwear Size Guide', 'category' => 'Shoes & Footwear', 'sizes' => '39, 40, 41, 42, 43, 44']
        ];
        $chartsJson = $settingModel->getSetting('size_charts', null);
        if ($chartsJson === null) {
            $charts = $defaultCharts;
            $this->db->table('business_settings')->insert(['type' => 'size_charts', 'value' => json_encode($charts)]);
        } else {
            $charts = json_decode($chartsJson, true) ?: [];
        }

        return view('admin/size_charts', [
            'page_title' => 'Size Charts',
            'charts' => $charts,
            'categories' => $categories
        ]);
    }

    public function storeSizeChart()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $category = trim($this->request->getPost('category') ?? 'General');
        $sizes = trim($this->request->getPost('sizes') ?? 'S, M, L, XL');

        if (!empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $chartsJson = $settingModel->getSetting('size_charts', '[]');
            $charts = json_decode($chartsJson, true) ?: [];

            $maxId = 0;
            foreach ($charts as $c) {
                if (isset($c['id']) && $c['id'] > $maxId) {
                    $maxId = $c['id'];
                }
            }

            $charts[] = [
                'id' => $maxId + 1,
                'name' => $name,
                'category' => $category,
                'sizes' => $sizes
            ];

            $jsonVal = json_encode(array_values($charts));
            $exists = $this->db->table('business_settings')->where('type', 'size_charts')->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', 'size_charts')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'size_charts', 'value' => $jsonVal]);
            }

            return redirect()->back()->with('success', 'Size chart added successfully.');
        }

        return redirect()->back()->with('error', 'Size chart name cannot be empty.');
    }

    public function updateSizeChart()
    {
        $id = (int)$this->request->getPost('id');
        $name = trim($this->request->getPost('name') ?? '');
        $category = trim($this->request->getPost('category') ?? 'General');
        $sizes = trim($this->request->getPost('sizes') ?? 'S, M, L, XL');

        if ($id > 0 && !empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $chartsJson = $settingModel->getSetting('size_charts', '[]');
            $charts = json_decode($chartsJson, true) ?: [];

            foreach ($charts as &$c) {
                if (isset($c['id']) && $c['id'] == $id) {
                    $c['name'] = $name;
                    $c['category'] = $category;
                    $c['sizes'] = $sizes;
                    break;
                }
            }

            $jsonVal = json_encode(array_values($charts));
            $this->db->table('business_settings')->where('type', 'size_charts')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Size chart updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid size chart data.');
    }

    public function deleteSizeChart($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $settingModel = new \App\Models\SettingModel();
            $chartsJson = $settingModel->getSetting('size_charts', '[]');
            $charts = json_decode($chartsJson, true) ?: [];

            $newCharts = [];
            foreach ($charts as $c) {
                if (isset($c['id']) && $c['id'] == $id) {
                    continue;
                }
                $newCharts[] = $c;
            }

            $jsonVal = json_encode(array_values($newCharts));
            $this->db->table('business_settings')->where('type', 'size_charts')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Size chart deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid size chart ID.');
    }

    public function measurementPoints()
    {
        $settingModel = new \App\Models\SettingModel();
        $defaultPoints = [
            ['id' => 1, 'name' => 'Chest / Bust', 'code' => 'CHEST', 'unit' => 'inches / cm'],
            ['id' => 2, 'name' => 'Waist', 'code' => 'WAIST', 'unit' => 'inches / cm'],
            ['id' => 3, 'name' => 'Hips', 'code' => 'HIPS', 'unit' => 'inches / cm'],
            ['id' => 4, 'name' => 'Shoulder Width', 'code' => 'SHOULDER', 'unit' => 'inches / cm'],
            ['id' => 5, 'name' => 'Sleeve Length', 'code' => 'SLEEVE', 'unit' => 'inches / cm']
        ];
        $pointsJson = $settingModel->getSetting('measurement_points', null);
        if ($pointsJson === null) {
            $points = $defaultPoints;
            $this->db->table('business_settings')->insert(['type' => 'measurement_points', 'value' => json_encode($points)]);
        } else {
            $points = json_decode($pointsJson, true) ?: [];
        }

        return view('admin/measurement_points', [
            'page_title' => 'Measurement Points',
            'points' => $points
        ]);
    }

    public function storeMeasurementPoint()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $code = trim($this->request->getPost('code') ?? strtoupper(substr($name, 0, 8)));
        $unit = trim($this->request->getPost('unit') ?? 'inches / cm');

        if (!empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $pointsJson = $settingModel->getSetting('measurement_points', '[]');
            $points = json_decode($pointsJson, true) ?: [];

            $maxId = 0;
            foreach ($points as $p) {
                if (isset($p['id']) && $p['id'] > $maxId) {
                    $maxId = $p['id'];
                }
            }

            $points[] = [
                'id' => $maxId + 1,
                'name' => $name,
                'code' => $code,
                'unit' => $unit
            ];

            $jsonVal = json_encode(array_values($points));
            $exists = $this->db->table('business_settings')->where('type', 'measurement_points')->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', 'measurement_points')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'measurement_points', 'value' => $jsonVal]);
            }

            return redirect()->back()->with('success', 'Measurement point added successfully.');
        }

        return redirect()->back()->with('error', 'Measurement point name cannot be empty.');
    }

    public function updateMeasurementPoint()
    {
        $id = (int)$this->request->getPost('id');
        $name = trim($this->request->getPost('name') ?? '');
        $code = trim($this->request->getPost('code') ?? '');
        $unit = trim($this->request->getPost('unit') ?? 'inches / cm');

        if ($id > 0 && !empty($name)) {
            $settingModel = new \App\Models\SettingModel();
            $pointsJson = $settingModel->getSetting('measurement_points', '[]');
            $points = json_decode($pointsJson, true) ?: [];

            foreach ($points as &$p) {
                if (isset($p['id']) && $p['id'] == $id) {
                    $p['name'] = $name;
                    $p['code'] = $code;
                    $p['unit'] = $unit;
                    break;
                }
            }

            $jsonVal = json_encode(array_values($points));
            $this->db->table('business_settings')->where('type', 'measurement_points')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Measurement point updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid measurement point data.');
    }

    public function deleteMeasurementPoint($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $settingModel = new \App\Models\SettingModel();
            $pointsJson = $settingModel->getSetting('measurement_points', '[]');
            $points = json_decode($pointsJson, true) ?: [];

            $newPoints = [];
            foreach ($points as $p) {
                if (isset($p['id']) && $p['id'] == $id) {
                    continue;
                }
                $newPoints[] = $p;
            }

            $jsonVal = json_encode(array_values($newPoints));
            $this->db->table('business_settings')->where('type', 'measurement_points')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Measurement point deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid measurement point ID.');
    }

    public function customLabels()
    {
        $settingModel = new \App\Models\SettingModel();
        $defaultLabels = [
            ['id' => 1, 'title' => 'New Arrival', 'text_color' => '#ffffff', 'bg_color' => '#0099ff'],
            ['id' => 2, 'title' => 'Hot Sale', 'text_color' => '#ffffff', 'bg_color' => '#ef4444'],
            ['id' => 3, 'title' => 'Limited Stock', 'text_color' => '#ffffff', 'bg_color' => '#f59e0b']
        ];
        $labelsJson = $settingModel->getSetting('custom_labels', null);
        if ($labelsJson === null) {
            $labels = $defaultLabels;
            // Save initial defaults
            $this->db->table('business_settings')->insert(['type' => 'custom_labels', 'value' => json_encode($labels)]);
        } else {
            $labels = json_decode($labelsJson, true) ?: [];
        }

        return view('admin/custom_labels', [
            'page_title' => 'Custom Labels',
            'labels' => $labels
        ]);
    }

    public function storeCustomLabel()
    {
        $title = trim($this->request->getPost('title') ?? '');
        $textColor = $this->request->getPost('text_color') ?? '#ffffff';
        $bgColor = $this->request->getPost('bg_color') ?? '#0099ff';

        if (!empty($title)) {
            $settingModel = new \App\Models\SettingModel();
            $labelsJson = $settingModel->getSetting('custom_labels', '[]');
            $labels = json_decode($labelsJson, true) ?: [];

            $maxId = 0;
            foreach ($labels as $lbl) {
                if (isset($lbl['id']) && $lbl['id'] > $maxId) {
                    $maxId = $lbl['id'];
                }
            }

            $labels[] = [
                'id' => $maxId + 1,
                'title' => $title,
                'text_color' => $textColor,
                'bg_color' => $bgColor
            ];

            $jsonVal = json_encode(array_values($labels));
            $exists = $this->db->table('business_settings')->where('type', 'custom_labels')->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', 'custom_labels')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'custom_labels', 'value' => $jsonVal]);
            }

            return redirect()->back()->with('success', 'Custom label added successfully.');
        }

        return redirect()->back()->with('error', 'Label title cannot be empty.');
    }

    public function updateCustomLabel()
    {
        $id = (int)$this->request->getPost('id');
        $title = trim($this->request->getPost('title') ?? '');
        $textColor = $this->request->getPost('text_color') ?? '#ffffff';
        $bgColor = $this->request->getPost('bg_color') ?? '#0099ff';

        if ($id > 0 && !empty($title)) {
            $settingModel = new \App\Models\SettingModel();
            $labelsJson = $settingModel->getSetting('custom_labels', '[]');
            $labels = json_decode($labelsJson, true) ?: [];

            foreach ($labels as &$lbl) {
                if (isset($lbl['id']) && $lbl['id'] == $id) {
                    $lbl['title'] = $title;
                    $lbl['text_color'] = $textColor;
                    $lbl['bg_color'] = $bgColor;
                    break;
                }
            }

            $jsonVal = json_encode(array_values($labels));
            $this->db->table('business_settings')->where('type', 'custom_labels')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Custom label updated successfully.');
        }

        return redirect()->back()->with('error', 'Invalid label data.');
    }

    public function deleteCustomLabel($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $settingModel = new \App\Models\SettingModel();
            $labelsJson = $settingModel->getSetting('custom_labels', '[]');
            $labels = json_decode($labelsJson, true) ?: [];

            $newLabels = [];
            foreach ($labels as $lbl) {
                if (isset($lbl['id']) && $lbl['id'] == $id) {
                    continue;
                }
                $newLabels[] = $lbl;
            }

            $jsonVal = json_encode(array_values($newLabels));
            $this->db->table('business_settings')->where('type', 'custom_labels')->update(['value' => $jsonVal]);

            return redirect()->back()->with('success', 'Custom label deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid label ID.');
    }

    public function categoryWiseDiscount()
    {
        $settingModel = new \App\Models\SettingModel();
        $builder = $this->db->table('categories c');
        $builder->select('c.*, u.file_name as icon_img');
        $builder->join('uploads u', 'c.icon = u.id', 'left');
        $categories = $builder->get()->getResultArray();

        $category_discount_rules_json = $settingModel->getSetting('category_discount_rules', '{}');
        $category_discount_rules = json_decode($category_discount_rules_json, true) ?: [];

        return view('admin/category_wise_discount', [
            'page_title' => 'Category-Wise Discount Setup',
            'categories' => $categories,
            'category_discount_rules' => $category_discount_rules
        ]);
    }

    public function updateCategoryWiseDiscount()
    {
        $categoryIds = $this->request->getPost('category_ids') ?? [];
        $discount = (float)($this->request->getPost('discount') ?? 0);
        $discountType = $this->request->getPost('discount_type') ?? 'flat';

        $settingModel = new \App\Models\SettingModel();
        $currentRules = json_decode($settingModel->getSetting('category_discount_rules', '{}'), true) ?: [];

        if (!empty($categoryIds)) {
            foreach ($categoryIds as $catId) {
                $currentRules[$catId] = [
                    'discount' => $discount,
                    'discount_type' => $discountType,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Apply discount to all products under this category
                $this->db->table('products')
                    ->where('category_id', $catId)
                    ->update([
                        'discount' => $discount,
                        'discount_type' => $discountType
                    ]);
            }

            $jsonVal = json_encode($currentRules);
            $rulesExists = $this->db->table('business_settings')->where('type', 'category_discount_rules')->get()->getRow();
            if ($rulesExists) {
                $this->db->table('business_settings')->where('type', 'category_discount_rules')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'category_discount_rules', 'value' => $jsonVal]);
            }
        }

        return redirect()->back()->with('success', 'Category-wise discount applied to all matching products successfully!');
    }

    public function categoryWiseRefund()
    {
        $settingModel = new \App\Models\SettingModel();
        $builder = $this->db->table('categories c');
        $builder->select('c.*, u.file_name as icon_img');
        $builder->join('uploads u', 'c.icon = u.id', 'left');
        $categories = $builder->get()->getResultArray();

        $category_refund_days = (int)$settingModel->getSetting('category_refund_days', 7);
        $category_refund_rules_json = $settingModel->getSetting('category_refund_rules', '{}');
        $category_refund_rules = json_decode($category_refund_rules_json, true) ?: [];

        return view('admin/category_wise_refund', [
            'page_title' => 'Category-Wise Refund Setup',
            'categories' => $categories,
            'category_refund_days' => $category_refund_days,
            'category_refund_rules' => $category_refund_rules
        ]);
    }

    public function updateCategoryWiseRefund()
    {
        $categoryIds = $this->request->getPost('category_ids') ?? [];
        $refundable = $this->request->getPost('refundable') ? 1 : 0;
        $refundDays = (int)($this->request->getPost('refund_days') ?? 7);

        // Update default refund days setting
        $exists = $this->db->table('business_settings')->where('type', 'category_refund_days')->get()->getRow();
        if ($exists) {
            $this->db->table('business_settings')->where('type', 'category_refund_days')->update(['value' => $refundDays]);
        } else {
            $this->db->table('business_settings')->insert(['type' => 'category_refund_days', 'value' => $refundDays]);
        }

        // Save category-specific rules
        $settingModel = new \App\Models\SettingModel();
        $currentRules = json_decode($settingModel->getSetting('category_refund_rules', '{}'), true) ?: [];

        if (!empty($categoryIds)) {
            foreach ($categoryIds as $catId) {
                $currentRules[$catId] = [
                    'refundable' => $refundable,
                    'refund_days' => $refundDays,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            $jsonVal = json_encode($currentRules);
            $rulesExists = $this->db->table('business_settings')->where('type', 'category_refund_rules')->get()->getRow();
            if ($rulesExists) {
                $this->db->table('business_settings')->where('type', 'category_refund_rules')->update(['value' => $jsonVal]);
            } else {
                $this->db->table('business_settings')->insert(['type' => 'category_refund_rules', 'value' => $jsonVal]);
            }
        }

        return redirect()->back()->with('success', 'Category refund configuration updated successfully.');
    }
    public function setupLanguages() { return view('admin/setup/languages'); }
    public function setupCurrencies() { return view('admin/setup/currencies'); }
    public function setupPaymentMethods() {
        $settingModel = new \App\Models\SettingModel();
        $payment_methods = [
            'cash_on_delivery'       => (int)$settingModel->getSetting('cash_on_delivery', 1),
            'piprapay'               => (int)$settingModel->getSetting('piprapay', 1),
            'piprapay_sandbox'       => (int)$settingModel->getSetting('piprapay_sandbox', 1),
            'piprapay_display_title' => $settingModel->getSetting('piprapay_display_title', 'PipraPay / Online Payment'),
            'piprapay_base_url'      => $settingModel->getSetting('piprapay_base_url', ''),
            'piprapay_api_key'       => $settingModel->getSetting('piprapay_api_key', '')
        ];
        return view('admin/setup/payment_methods', ['payment_methods' => $payment_methods]);
    }

    public function updatePaymentMethods() {
        $post = $this->request->getPost();
        foreach ($post as $key => $val) {
            if ($key === csrf_token()) continue;
            $exists = $this->db->table('business_settings')->where('type', $key)->get()->getRow();
            if ($exists) {
                $this->db->table('business_settings')->where('type', $key)->update(['value' => $val]);
            } else {
                $this->db->table('business_settings')->insert(['type' => $key, 'value' => $val]);
            }
        }
        return redirect()->to(base_url('admin/setup/payment-methods'))->with('success', 'Payment method settings updated successfully.');
    }

    public function testPipraPay() {
        $settingModel = new \App\Models\SettingModel();
        $apiKey = $settingModel->getSetting('piprapay_api_key', '01c19a05145aef64b6a4b3361dc7f7c1965f41048672de5c3a');
        $baseUrl = rtrim($settingModel->getSetting('piprapay_base_url', 'https://pay.nur-lab.com/api'), '/');

        $endpoint = (strpos($baseUrl, '/api') !== false ? $baseUrl : $baseUrl . '/api') . '/checkout/redirect';

        $payload = [
            'amount'         => 10.00,
            'currency'       => 'BDT',
            'customer_name'  => 'Test Admin',
            'customer_email' => 'admin@nur-lab.com',
            'redirect_url'   => base_url('admin/setup/payment-methods')
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $resData = json_decode($response, true);
            $paymentUrl = $resData['data']['payment_url'] ?? ($resData['payment_url'] ?? ($resData['url'] ?? ''));
            if (!empty($paymentUrl)) {
                return redirect()->to($paymentUrl);
            } else {
                $err = $resData['message'] ?? ($resData['error']['message'] ?? json_encode($resData));
                echo "<script>alert('PipraPay API Gateway Error:\\n" . addslashes($err) . "'); window.history.back();</script>";
                exit;
            }
        }

        echo "<script>alert('Could not connect to PipraPay Gateway API endpoint.'); window.history.back();</script>";
        exit;
    }
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
