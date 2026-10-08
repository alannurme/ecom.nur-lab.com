<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Features Activation</h1>
    <span class="fs-13 text-muted">Enable or disable system features and operational modules</span>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Infrastructure Section -->
    <div class="mb-4">
        <h5 class="fs-14 fw-700 text-uppercase mb-3 text-secondary">Infrastructure</h5>
        <div class="row gutters-15">
            <?php
            $infra = [
                ['name' => 'HTTPS Activation', 'desc' => 'Force the website to load over a secure HTTPS connection.', 'key' => 'force_https'],
                ['name' => 'Maintenance Mode', 'desc' => 'Temporarily disable the website frontend and show maintenance notice.', 'key' => 'maintenance_mode'],
                ['name' => 'Disable Image Encoding', 'desc' => 'Disable image encoding and skip automated WebP image optimization.', 'key' => 'disable_image_optimization'],
            ];
            foreach ($infra as $item):
                $val = $features[$item['key']] ?? 0;
            ?>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm border-0 rounded-2 p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="avatar avatar-xs bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="las la-cog fs-18"></i>
                        </span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="toggleFeature('<?= $item['key'] ?>', this.checked)" <?= $val ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <h6 class="fw-600 fs-15 text-dark mb-1"><?= $item['name'] ?></h6>
                    <span class="fs-12 text-muted"><?= $item['desc'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Business & E-Commerce Features -->
    <div class="mb-4">
        <h5 class="fs-14 fw-700 text-uppercase mb-3 text-secondary">Business & E-Commerce Systems</h5>
        <div class="row gutters-15">
            <?php
            $biz = [
                ['name' => 'Multivendor / Seller System', 'desc' => 'Allow third-party sellers to register and list products on your platform.', 'key' => 'vendor_system_activation'],
                ['name' => 'Classified Product System', 'desc' => 'Allow users to post classified ads and used items for sale.', 'key' => 'classified_product'],
                ['name' => 'Auction Product System', 'desc' => 'Enable bidding and auction features for products.', 'key' => 'auction_product'],
                ['name' => 'Wholesale Product System', 'desc' => 'Enable tiered quantity pricing for wholesale buyers.', 'key' => 'wholesale_product'],
                ['name' => 'POS System', 'desc' => 'Enable Point of Sale module for offline retail store sales.', 'key' => 'pos_system'],
                ['name' => 'Coupon System', 'desc' => 'Enable discount coupons and promo codes during checkout.', 'key' => 'coupon_system'],
            ];
            foreach ($biz as $item):
                $val = $features[$item['key']] ?? 0;
            ?>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm border-0 rounded-2 p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="avatar avatar-xs bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center">
                            <i class="las la-store fs-18"></i>
                        </span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="toggleFeature('<?= $item['key'] ?>', this.checked)" <?= $val ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <h6 class="fw-600 fs-15 text-dark mb-1"><?= $item['name'] ?></h6>
                    <span class="fs-12 text-muted"><?= $item['desc'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function toggleFeature(key, status) {
    $.ajax({
        url: '<?= base_url('admin/setup/features/update') ?>',
        type: 'POST',
        data: {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
            key: key,
            status: status ? 1 : 0
        },
        success: function(response) {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify(response.status ? 'success' : 'danger', response.message);
            } else {
                console.log(response.message);
            }
        },
        error: function() {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Something went wrong while updating feature status.');
            }
        }
    });
}
</script>

<?= $this->include('admin/layouts/footer') ?>
