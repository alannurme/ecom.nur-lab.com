<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="bg-white rounded-2 border shadow-sm p-3">
                    <div class="text-center py-3 border-bottom mb-3">
                        <div class="size-60px bg-soft-primary rounded-circle mx-auto d-flex align-items-center justify-content-center text-primary fs-24 font-weight-bold mb-2">
                            <?= esc(strtoupper(substr($seller['name'] ?? 'S', 0, 1))) ?>
                        </div>
                        <h6 class="font-weight-bold mb-0"><?= esc($seller['name'] ?? 'Seller') ?></h6>
                        <span class="badge badge-inline badge-soft-success fs-11 mt-1">Verified Seller</span>
                    </div>

                    <div class="nav flex-column nav-pills">
                        <a href="<?= base_url('seller/dashboard') ?>" class="nav-link active py-2.5 px-3 mb-1 font-weight-bold rounded-2">
                            <i class="las la-home mr-2 fs-16"></i> Dashboard Overview
                        </a>
                        <a href="<?= base_url('admin/products/seller') ?>" class="nav-link py-2.5 px-3 mb-1 text-secondary font-weight-bold rounded-2">
                            <i class="las la-box mr-2 fs-16"></i> My Products
                        </a>
                        <a href="<?= base_url('admin/orders/seller') ?>" class="nav-link py-2.5 px-3 mb-1 text-secondary font-weight-bold rounded-2">
                            <i class="las la-shopping-cart mr-2 fs-16"></i> Orders
                        </a>
                        <a href="<?= base_url('seller/logout') ?>" class="nav-link py-2.5 px-3 text-danger font-weight-bold rounded-2">
                            <i class="las la-sign-out-alt mr-2 fs-16"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="bg-white rounded-2 border shadow-sm p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="font-weight-bold text-dark mb-1">Welcome back, <?= esc($seller['name'] ?? 'Seller') ?>!</h4>
                            <p class="text-muted fs-13 mb-0">Here is what is happening with your store today.</p>
                        </div>
                        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary fw-600 rounded-2">
                            <i class="las la-plus mr-1"></i> Add New Product
                        </a>
                    </div>
                </div>

                <div class="row gutters-10 mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="bg-white border rounded-2 p-3 shadow-sm d-flex align-items-center">
                            <div class="size-48px bg-soft-primary rounded-circle d-flex align-items-center justify-content-center text-primary fs-20 mr-3">
                                <i class="las la-box"></i>
                            </div>
                            <div>
                                <span class="fs-12 text-muted fw-600 d-block">Total Products</span>
                                <h4 class="mb-0 font-weight-bold">12</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="bg-white border rounded-2 p-3 shadow-sm d-flex align-items-center">
                            <div class="size-48px bg-soft-success rounded-circle d-flex align-items-center justify-content-center text-success fs-20 mr-3">
                                <i class="las la-shopping-bag"></i>
                            </div>
                            <div>
                                <span class="fs-12 text-muted fw-600 d-block">Total Orders</span>
                                <h4 class="mb-0 font-weight-bold">48</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white border rounded-2 p-3 shadow-sm d-flex align-items-center">
                            <div class="size-48px bg-soft-warning rounded-circle d-flex align-items-center justify-content-center text-warning fs-20 mr-3">
                                <i class="las la-wallet"></i>
                            </div>
                            <div>
                                <span class="fs-12 text-muted fw-600 d-block">Total Earnings</span>
                                <h4 class="mb-0 font-weight-bold">৳ 45,200</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
