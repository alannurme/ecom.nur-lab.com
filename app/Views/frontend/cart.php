<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <h3 class="fs-22 fw-800 text-dark mb-4"><i class="las la-shopping-cart text-primary mr-1"></i> Shopping Cart</h3>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="las la-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($cart)): ?>
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="bg-white rounded-lg border shadow-sm p-3">
                        <div class="table-responsive">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr class="fs-12 text-secondary bg-light">
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th class="text-right">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= !empty($item['thumbnail']) ? base_url($item['thumbnail']) : base_url('assets/img/placeholder.jpg') ?>" 
                                                         alt="" width="50" height="50" class="rounded border mr-3" style="object-fit: cover;"
                                                         onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                                    <div>
                                                        <a href="<?= base_url('product/' . $item['slug']) ?>" class="fw-700 text-dark text-decoration-none d-block">
                                                            <?= esc($item['name']) ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-700 text-dark">৳<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <span class="badge badge-light border px-3 py-2 fs-13 fw-700"><?= $item['qty'] ?></span>
                                            </td>
                                            <td class="fw-800 text-primary">৳<?= number_format($item['price'] * $item['qty'], 2) ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-soft-danger btn-icon btn-circle btn-sm">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary Box -->
                <div class="col-lg-4">
                    <div class="bg-white rounded-lg border shadow-sm p-4">
                        <h5 class="fs-16 fw-800 text-dark border-bottom pb-3 mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2 fs-14">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-700 text-dark">৳<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 fs-14">
                            <span class="text-secondary">Shipping</span>
                            <span class="fw-600 text-success">Calculated at Checkout</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 fs-18">
                            <span class="fw-800 text-dark">Total</span>
                            <span class="fw-800 text-primary">৳<?= number_format($total, 2) ?></span>
                        </div>
                        <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-block btn-lg fw-700">
                            Proceed to Checkout <i class="las la-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg border shadow-sm text-center py-5 px-3">
                <i class="las la-shopping-cart text-muted fs-60 mb-3"></i>
                <h4 class="fw-700 text-dark">Your cart is currently empty!</h4>
                <p class="text-secondary fs-14 mb-4">Explore our wide range of products and start shopping now.</p>
                <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg fw-700 px-5">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
