<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\SettingModel;

class Checkout extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $cart = $this->session->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Your cart is empty.');
        }

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

        return view('frontend/checkout', $data);
    }

    public function process()
    {
        $cart = $this->session->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to(base_url('cart'));
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $paymentMethod = $this->request->getPost('payment_option', 'cash_on_delivery');

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $shipping = 60.00;
        $grandTotal = $subtotal + $shipping;
        $orderCode = date('Ymd-His') . rand(10, 99);

        // Save order to database
        $orderData = [
            'user_id' => 0,
            'guest_id' => rand(10000, 99999),
            'seller_id' => 1,
            'shipping_address' => json_encode(['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address]),
            'delivery_status' => 'pending',
            'payment_type' => $paymentMethod,
            'payment_status' => 'unpaid',
            'grand_total' => $grandTotal,
            'coupon_discount' => 0,
            'code' => $orderCode,
            'date' => strtotime('now'),
            'viewed' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('orders')->insert($orderData);
        $orderId = $this->db->insertID();

        // Save order details
        foreach ($cart as $item) {
            $this->db->table('order_details')->insert([
                'order_id' => $orderId,
                'seller_id' => 1,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'tax' => 0,
                'shipping_cost' => 0,
                'quantity' => $item['qty'],
                'payment_status' => 'unpaid',
                'delivery_status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Clear cart
        $this->session->remove('cart');

        return redirect()->to(base_url('order-success/' . $orderCode));
    }

    public function success($code)
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'order_code' => $code
        ];

        return view('frontend/order_success', $data);
    }
}
