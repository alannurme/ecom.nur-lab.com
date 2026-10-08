<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fs-18 fw-600 text-dark mb-1">Dashboard</h2>
        <span class="fs-12 fw-400 text-dark">Central hub of your business</span>
    </div>
    <div class="d-flex align-items-center">
        <div class="fs-16 fw-bold d-flex align-items-center justify-content-center w-40px h-40px rounded-circle bg-light mr-2">
            <?= date('d') ?>
        </div>
        <span class="fs-12 fw-400"><?= date('l, F Y') ?></span>
    </div>
</div>

<div class="row gutters-16">
    <div class="col-lg-6">
        <div class="row gutters-16">
            <!-- Registered Customer Box -->
            <div class="col-sm-6">
                <div class="dashboard-box h-220px mb-2rem overflow-hidden bg-white p-4 border rounded">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_customers) ?></h1>
                                <h3 class="fs-13 fw-400 text-reset mb-0">Registered Customer</h3>
                            </div>
                            <div class="mt-2">
                                <img src="<?= base_url('assets/img/total-customer.svg') ?>" alt="Total Customer">
                            </div>
                        </div>
                        <div>
                            <h3 class="fs-13 fw-400 mb-2">
                                <span class="badge badge-md badge-dot badge-circle badge-danger mr-2"></span>
                                Top Customers
                            </h3>
                            <div class="symbol-group">
                                <?php if (!empty($top_customers)): ?>
                                    <?php foreach ($top_customers as $top_customer): ?>
                                        <div class="symbol size-40px rounded-content overflow-hidden" title="<?= esc($top_customer->name ?? 'Customer') ?>">
                                            <img src="<?= base_url('assets/img/placeholder.jpg') ?>" alt="customer" class="h-100 img-fit">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge badge-soft-primary px-3 py-2 fs-12"><?= number_format($total_customers) ?> Active Users</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Products Box -->
            <div class="col-sm-6">
                <div class="dashboard-box h-220px mb-2rem overflow-hidden bg-white p-4 border rounded">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_products) ?></h1>
                                <h3 class="fs-13 fw-400 text-reset mb-0">Total Products</h3>
                            </div>
                            <div class="mt-2">
                                <img src="<?= base_url('assets/img/total-products.svg') ?>" alt="Total Products">
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <h3 class="fs-13 fw-400 text-truncate mb-0 mr-2">
                                    <span class="badge badge-md badge-dot badge-circle badge-success mr-2"></span>
                                    In-house Products
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_inhouse_products) ?></h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-13 fw-400 text-truncate mr-2">
                                    <span class="badge badge-md badge-dot badge-circle badge-primary mr-2"></span>
                                    Sellers Products
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_sellers_products) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Category Box -->
            <div class="col-sm-6">
                <div class="dashboard-box h-220px mb-2rem overflow-hidden bg-white p-4 border rounded">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_categories) ?></h1>
                                <h3 class="fs-13 fw-400 text-reset mb-0">Total Category</h3>
                            </div>
                            <div class="mt-2">
                                <img src="<?= base_url('assets/img/total-category.svg') ?>" alt="Total Category">
                            </div>
                        </div>
                        <div>
                            <?php if (!empty($top_categories)): ?>
                                <?php foreach ($top_categories as $key => $top_cat): ?>
                                    <div class="d-flex justify-content-between mt-2">
                                        <h3 class="fs-13 fw-400 text-reset d-flex align-items-center text-truncate mb-0 mr-2">
                                            <span class="badge badge-sm badge-dot badge-danger mr-2" style="height:4px !important; width:20px !important;"></span>
                                            <?= esc($top_cat->name) ?>
                                        </h3>
                                        <h3 class="fs-13 fw-400 mb-0">৳<?= number_format($top_cat->total ?? 0, 2) ?></h3>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="d-flex justify-content-between mt-2">
                                    <h3 class="fs-13 fw-400 text-reset mb-0">Active Categories</h3>
                                    <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_categories) ?></h3>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Brands Box -->
            <div class="col-sm-6">
                <div class="dashboard-box h-220px mb-2rem overflow-hidden bg-white p-4 border rounded">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_brands) ?></h1>
                                <h3 class="fs-13 fw-400 text-reset mb-0">Total Brands</h3>
                            </div>
                            <div class="mt-2">
                                <img src="<?= base_url('assets/img/total-brands.svg') ?>" alt="Total Brands">
                            </div>
                        </div>
                        <div>
                            <?php if (!empty($top_brands)): ?>
                                <?php foreach ($top_brands as $key => $top_brand): ?>
                                    <div class="d-flex justify-content-between mb-0 mt-2">
                                        <h3 class="fs-13 fw-400 text-truncate mb-0 mr-2">
                                            <span class="badge badge-md badge-dot badge-circle badge-info mr-2"></span>
                                            <?= esc($top_brand->name) ?>
                                        </h3>
                                        <h3 class="fs-13 fw-400 text-reset mb-0">৳<?= number_format($top_brand->total ?? 0, 2) ?></h3>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="d-flex justify-content-between mt-2">
                                    <h3 class="fs-13 fw-400 text-reset mb-0">Active Brands</h3>
                                    <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_brands) ?></h3>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column Overview -->
    <div class="col-lg-6">
        <div class="row gutters-16">
            <div class="col-sm-6">
                <div class="dashboard-box mb-2rem overflow-hidden bg-white p-4 border rounded" style="height: 470px;">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <h1 class="fs-30 fw-600 text-dark mb-1">৳<?= number_format($total_sale, 2) ?></h1>
                            <h3 class="fs-13 fw-400 text-reset mb-0">All Time Sales</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between rounded-2 bg-primary p-3 text-white">
                            <h3 class="fs-13 fw-600 mb-0">Sales this month</h3>
                            <h3 class="fs-13 fw-600 mb-0">৳<?= number_format($sale_this_month, 2) ?></h3>
                        </div>
                        <div>
                            <h3 class="fs-13 fw-400 text-reset mb-0">Sales State</h3>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <h3 class="fs-13 fw-400 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-info text-truncate mr-2"></span>
                                    In-house Sales
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">৳<?= number_format($admin_sale_this_month->total_sale ?? $total_sale, 2) ?></h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-13 fw-400 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-success text-truncate mr-2"></span>
                                    Sellers Sales
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">৳0.00</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="dashboard-box mb-2rem overflow-hidden bg-white p-4 border rounded" style="height: 470px;">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <h1 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_sellers) ?></h1>
                            <h3 class="fs-13 fw-400 text-reset mb-0">Sellers in the Platform</h3>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <h3 class="fs-13 fw-400 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-success text-truncate mr-2"></span>
                                    Approved Sellers
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_approved_sellers) ?></h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-13 fw-400 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-danger text-truncate mr-2"></span>
                                    Pending Seller
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0"><?= number_format($total_pending_sellers) ?></h3>
                            </div>
                        </div>
                        <div>
                            <h3 class="fs-13 fw-400 mb-2">
                                <span class="badge badge-md badge-dot badge-circle badge-warning mr-2"></span>
                                Top Sellers
                            </h3>
                            <div class="symbol-group">
                                <?php if (!empty($top_sellers)): ?>
                                    <?php foreach ($top_sellers as $ts): ?>
                                        <div class="symbol size-40px rounded-content overflow-hidden" title="<?= esc($ts->name ?? 'Seller') ?>">
                                            <img src="<?= base_url('assets/img/placeholder.jpg') ?>" alt="seller" class="h-100 img-fit">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge badge-soft-info px-3 py-2 fs-12">Stores Active</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Fullfillment Overview section -->
<div class="dashboard-box mb-2rem p-4 overflow-hidden bg-white border rounded">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="fs-16 fw-700 text-dark mb-0">Orders</h2>
        <div class="d-flex align-items-center rounded-pill px-3 py-1 bg-soft-primary">
            <span class="d-block w-10px h-10px bg-primary rounded-circle mr-2"></span>
            <span class="fs-13 fw-600 text-primary">Fulfilment Rate: <?= $total_delivered_order_percentage ?>%</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h3 class="fs-30 fw-600 text-dark mb-1"><?= number_format($total_order) ?></h3>
            <h4 class="fs-13 fw-400 text-secondary mb-3">All Types of Orders</h4>
            <div class="card bg-light border-0 p-3 mb-2">
                <div class="d-flex align-items-center">
                    <div class="w-10px h-10px rounded-circle bg-success mr-2"></div>
                    <span class="fs-13 fw-400 text-dark">In-house Orders</span>
                </div>
                <div class="fs-20 fw-600 text-dark pb-1 pt-2"><?= number_format($total_inhouse_order) ?></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fs-13 fw-500">Delivered Orders</span>
                        <strong class="fs-13 fw-700 text-success"><?= $total_delivered_order ?></strong>
                    </div>
                    <div class="progress h-5px">
                        <div class="progress-bar bg-success" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fs-13 fw-500">Pending Orders</span>
                        <strong class="fs-13 fw-700 text-warning"><?= $total_pending_order ?></strong>
                    </div>
                    <div class="progress h-5px">
                        <div class="progress-bar bg-warning" style="width: <?= $total_pending_order_percentage ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products Section -->
<div class="card mb-4">
    <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center bg-white">
        <h5 class="fs-16 fw-700 text-dark mb-0">Recent Products</h5>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-primary btn-sm fw-600">All Products</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr class="fs-12 text-secondary bg-light">
                        <th>Thumbnail</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th class="text-right">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_products)): ?>
                        <?php foreach ($recent_products as $prod): ?>
                            <tr>
                                <td>
                                    <img src="<?= !empty($prod['thumbnail_path']) ? base_url($prod['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>" alt="" width="40" height="40" class="rounded border" style="object-fit: cover;" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                </td>
                                <td class="fw-600 text-dark"><?= esc($prod['name']) ?></td>
                                <td><span class="badge badge-inline badge-light border"><?= esc($prod['category_name'] ?? 'General') ?></span></td>
                                <td class="fw-700 text-primary">৳<?= number_format($prod['unit_price'], 2) ?></td>
                                <td>
                                    <?php if ($prod['published'] == 1): ?>
                                        <span class="badge badge-inline badge-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge badge-inline badge-secondary">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?= base_url('admin/products') ?>" class="btn btn-soft-primary btn-icon btn-circle btn-sm"><i class="las la-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
