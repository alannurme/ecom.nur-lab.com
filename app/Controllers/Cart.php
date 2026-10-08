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

        $totalItems = 0;
        $totalPrice = 0.0;
        $cartHtml = '<ul class="list-group list-group-flush mb-0">';
        foreach ($cart as $cKey => $cItem) {
            $hQty = (int)($cItem['qty'] ?? 1);
            $hPrice = (float)($cItem['price'] ?? 0);
            $totalItems += $hQty;
            $totalPrice += $hPrice * $hQty;

            $thumb = !empty($cItem['thumbnail']) ? base_url($cItem['thumbnail']) : base_url('assets/img/placeholder.jpg');
            $cartHtml .= '<li class="list-group-item px-4 py-3 d-flex align-items-center justify-content-between border-bottom-light" style="transition: background-color 0.15s; background-color: #fff;">';
            $cartHtml .= '<div class="d-flex align-items-center overflow-hidden mr-3" style="flex: 1;">';
            $cartHtml .= '<img src="' . $thumb . '" alt="" width="52" height="52" class="rounded border mr-3 flex-shrink-0" style="object-fit: cover; border-color: #e2e8f0 !important;" onerror="this.src=\'' . base_url('assets/img/placeholder.jpg') . '\'">';
            $cartHtml .= '<div class="overflow-hidden">';
            $cartHtml .= '<h6 class="fs-14 fw-700 mb-1 text-dark text-truncate" style="color: #1e293b !important; line-height: 1.3;" title="' . esc($cItem['name']) . '">' . esc($cItem['name']) . '</h6>';
            $cartHtml .= '<div class="d-flex align-items-center fs-13">';
            $cartHtml .= '<span class="badge bg-light text-dark font-weight-bold fs-11 border mr-2 px-2 py-0.5" style="color: #334155 !important;">Qty: ' . $hQty . '</span>';
            $cartHtml .= '<span class="fw-700 text-primary fs-14">৳' . number_format($hPrice, 2) . '</span>';
            $cartHtml .= '</div></div></div>';
            $cartHtml .= '<a href="javascript:void(0)" onclick="removeFromCartDirect(' . $cKey . ', event)" class="text-danger p-2 rounded-circle hover-bg-light flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; text-decoration: none;" title="Remove from cart"><i class="las la-trash-alt fs-18"></i></a>';
            $cartHtml .= '</li>';
        }
        $cartHtml .= '</ul>';

        return $this->response->setJSON([
            'status'     => 'success', 
            'message'    => 'Product added to cart successfully!',
            'cart_count' => $totalItems,
            'cart_total' => '৳' . number_format($totalPrice, 2),
            'cart_html'  => $cartHtml
        ]);
    }

    public function updateQuantity()
    {
        $productId = $this->request->getPost('product_id');
        $action = $this->request->getPost('action'); // 'increase' or 'decrease' or numeric quantity
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['qty'] += 1;
            } elseif ($action === 'decrease') {
                $cart[$productId]['qty'] -= 1;
                if ($cart[$productId]['qty'] <= 0) {
                    unset($cart[$productId]);
                }
            } else {
                $qty = (int)$action;
                if ($qty > 0) {
                    $cart[$productId]['qty'] = $qty;
                } else {
                    unset($cart[$productId]);
                }
            }
            $this->session->set('cart', $cart);
        }

        return $this->buildCartResponse('Quantity updated.');
    }

    private function buildCartResponse($message = '')
    {
        $cart = $this->session->get('cart') ?? [];
        $totalItems = 0;
        $totalPrice = 0.0;
        $cartHtml = '';

        if (!empty($cart)) {
            $cartHtml .= '<ul class="list-group list-group-flush mb-0">';
            foreach ($cart as $cKey => $cItem) {
                $hQty = (int)($cItem['qty'] ?? 1);
                $hPrice = (float)($cItem['price'] ?? 0);
                $totalItems += $hQty;
                $totalPrice += $hPrice * $hQty;

                $thumb = !empty($cItem['thumbnail']) ? base_url($cItem['thumbnail']) : base_url('assets/img/placeholder.jpg');
                $cartHtml .= '<li class="list-group-item px-3 py-3 d-flex align-items-center justify-content-between border-bottom-light" style="transition: background-color 0.15s; background-color: #fff;">';
                $cartHtml .= '<div class="d-flex align-items-center overflow-hidden mr-2" style="flex: 1;">';
                $cartHtml .= '<img src="' . $thumb . '" alt="" width="48" height="48" class="rounded border mr-2 flex-shrink-0" style="object-fit: cover; border-color: #e2e8f0 !important;" onerror="this.src=\'' . base_url('assets/img/placeholder.jpg') . '\'">';
                $cartHtml .= '<div class="overflow-hidden">';
                $cartHtml .= '<h6 class="fs-13 fw-700 mb-1 text-dark text-truncate" style="color: #1e293b !important; line-height: 1.2;" title="' . esc($cItem['name']) . '">' . esc($cItem['name']) . '</h6>';
                $cartHtml .= '<div class="d-flex align-items-center fs-12">';
                $cartHtml .= '<span class="fw-700 text-primary mr-2">৳' . number_format($hPrice, 2) . '</span>';
                $cartHtml .= '<div class="input-group input-group-sm rounded border align-items-center bg-light" style="width: 85px;">';
                $cartHtml .= '<div class="input-group-prepend"><button class="btn btn-xs text-dark px-1.5 border-0" onclick="updateCartQtyDirect(' . $cKey . ', \'decrease\', event)"><i class="las la-minus fs-10"></i></button></div>';
                $cartHtml .= '<span class="form-control form-control-sm text-center border-0 px-0 bg-transparent fw-700 fs-11" style="height: auto; padding: 2px 0;">' . $hQty . '</span>';
                $cartHtml .= '<div class="input-group-append"><button class="btn btn-xs text-dark px-1.5 border-0" onclick="updateCartQtyDirect(' . $cKey . ', \'increase\', event)"><i class="las la-plus fs-10"></i></button></div>';
                $cartHtml .= '</div>';
                $cartHtml .= '</div></div></div>';
                $cartHtml .= '<a href="javascript:void(0)" onclick="removeFromCartDirect(' . $cKey . ', event)" class="text-danger p-1 rounded-circle hover-bg-light flex-shrink-0 d-flex align-items-center justify-content-center ml-1" style="width: 28px; height: 28px; text-decoration: none;" title="Remove"><i class="las la-trash-alt fs-16"></i></a>';
                $cartHtml .= '</li>';
            }
            $cartHtml .= '</ul>';
        } else {
            $cartHtml .= '<div class="text-center py-5 px-4">';
            $cartHtml .= '<div class="mb-3 d-inline-block p-3 rounded-circle bg-light text-muted"><i class="las la-shopping-basket fs-40" style="color: #94a3b8;"></i></div>';
            $cartHtml .= '<h6 class="fs-15 fw-700 text-dark mb-1" style="color: #1e293b !important;">Your cart is empty</h6>';
            $cartHtml .= '<p class="fs-13 text-muted mb-0">Add products to your cart to see them here.</p>';
            $cartHtml .= '</div>';
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => $message,
            'cart_count' => $totalItems,
            'cart_total' => '৳' . number_format($totalPrice, 2),
            'cart_html'  => $cartHtml
        ]);
    }

    public function removeAjax()
    {
        $productId = $this->request->getPost('product_id');
        $cart = $this->session->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
        }

        return $this->buildCartResponse('Item removed from cart.');
    }

    public function remove($productId)
    {
        $cart = $this->session->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
