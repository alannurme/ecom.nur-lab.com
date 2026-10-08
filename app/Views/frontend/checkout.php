<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <h3 class="fs-22 fw-800 text-dark mb-4"><i class="las la-truck text-primary mr-1"></i> Checkout & Delivery</h3>

        <form action="<?= base_url('checkout/process') ?>" method="POST">
            <div class="row">
                <!-- Shipping Address Form -->
                <div class="col-lg-7 mb-4">
                    <div class="bg-white rounded-lg border shadow-sm p-4 mb-4">
                        <h5 class="fs-16 fw-800 text-dark border-bottom pb-3 mb-3">1. Shipping Address</h5>
                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="fw-700 fs-13 text-dark">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="fw-700 fs-13 text-dark">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" placeholder="+880 17XXXXXXXX" required>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="fw-700 fs-13 text-dark">Delivery Address *</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="House no, Street, Area, City" required></textarea>
                        </div>
                    </div>

                    <!-- Payment Options -->
                    <div class="bg-white rounded-lg border shadow-sm p-4">
                        <h5 class="fs-16 fw-800 text-dark border-bottom pb-3 mb-3">2. Payment Method</h5>
                        <?php 
                        $firstChecked = true;
                        $hasPaymentMethod = false;
                        ?>
                        <?php if (!empty($cod_active) && $cod_active == 1): $hasPaymentMethod = true; ?>
                            <div class="custom-control custom-radio mb-3 p-3 border rounded">
                                <input type="radio" id="cod" name="payment_option" value="cash_on_delivery" class="custom-control-input" <?= $firstChecked ? 'checked' : '' ?>>
                                <label class="custom-control-label fw-700 text-dark cursor-pointer" for="cod">
                                    Cash on Delivery (COD)
                                    <small class="text-secondary d-block font-weight-normal">Pay with cash upon receiving your parcel.</small>
                                </label>
                            </div>
                            <?php $firstChecked = false; ?>
                        <?php endif; ?>

                        <?php if (!empty($piprapay_active) && $piprapay_active == 1): $hasPaymentMethod = true; ?>
                            <div class="custom-control custom-radio p-3 border rounded mb-3">
                                <input type="radio" id="online_payment" name="payment_option" value="online_payment" class="custom-control-input" <?= $firstChecked ? 'checked' : '' ?>>
                                <label class="custom-control-label fw-700 text-dark cursor-pointer" for="online_payment">
                                    <?= esc($piprapay_title ?? 'PipraPay / Online Payment') ?>
                                    <small class="text-secondary d-block font-weight-normal">Pay instantly via Mobile Banking, bKash, Nagad or Cards.</small>
                                </label>
                            </div>
                            <?php $firstChecked = false; ?>
                        <?php endif; ?>

                        <?php if (!$hasPaymentMethod): ?>
                            <div class="alert alert-warning mb-0">
                                <i class="las la-exclamation-triangle mr-1"></i> No payment methods are currently available. Please contact store support.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="bg-white rounded-lg border shadow-sm p-4">
                        <h5 class="fs-16 fw-800 text-dark border-bottom pb-3 mb-3">Order Details</h5>
                        <ul class="list-unstyled mb-4">
                            <?php foreach ($cart as $item): ?>
                                <li class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom-light">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= !empty($item['thumbnail']) ? base_url($item['thumbnail']) : base_url('assets/img/placeholder.jpg') ?>" 
                                             alt="" width="36" height="36" class="rounded border mr-2" style="object-fit: cover;"
                                             onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-700 text-dark fs-13 d-block text-truncate max-w-180px" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></span>
                                            <div class="d-flex align-items-center mt-1">
                                                <div class="input-group input-group-sm rounded border align-items-center bg-light" style="width: 80px;">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-xs text-dark px-1 border-0" onclick="updateCartQtyDirect('<?= $item['id'] ?>', 'decrease', event)"><i class="las la-minus fs-10"></i></button>
                                                    </div>
                                                    <span class="form-control form-control-sm text-center border-0 px-0 bg-transparent fw-700 fs-11" style="height: auto; padding: 1px 0;"><?= $item['qty'] ?></span>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-xs text-dark px-1 border-0" onclick="updateCartQtyDirect('<?= $item['id'] ?>', 'increase', event)"><i class="las la-plus fs-10"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-700 text-primary">৳<?= number_format($item['price'] * $item['qty'], 2) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="d-flex justify-content-between mb-2 fs-14">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-700 text-dark">৳<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 fs-14">
                            <span class="text-secondary">Shipping Fee</span>
                            <span class="fw-700 text-dark">৳60.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 fs-18">
                            <span class="fw-800 text-dark">Total Amount</span>
                            <span class="fw-800 text-primary">৳<?= number_format($total + 60, 2) ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg fw-700 py-3">
                            <i class="las la-check-circle mr-1"></i> Place Order Now
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
