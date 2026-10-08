<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Cart extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $cart = $this->session->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'cart' => $cart,
            'total' => $total
        ];

        return view('frontend/cart', $data);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $qty = (int)($this->request->getPost('quantity') ?? 1);

        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid product']);
        }

        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        $product = $db->table('products p')
            ->select('p.*, u.file_name as thumbnail_path')
            ->join('uploads u', 'p.thumbnail_img = u.id', 'left')
            ->where('p.id', $productId)
            ->get()
            ->getRowArray();

        if (!$product) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found']);
        }

        $finalPrice = $productModel->calculateFinalPrice($product);
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'price' => $finalPrice,
                'thumbnail' => $product['thumbnail_path'],
                'qty' => $qty
            ];
        }

        $this->session->set('cart', $cart);

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($cart)
        ]);
    }

    public function remove($productId)
    {
        $cart = $this->session->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
        }

        return redirect()->to(base_url('cart'))->with('success', 'Item removed from cart.');
    }
}
