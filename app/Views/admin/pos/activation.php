<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<h4 class="text-center text-dark mb-4 font-weight-bold">POS Activation for Seller</h4>

<div class="row justify-content-center">
    <!-- POS Activation Card -->
    <div class="col-lg-4 mb-4">
        <div class="card border">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fs-15 fw-700 text-dark">POS Activation for Seller</h5>
            </div>
            <div class="card-body text-center py-4">
                <div class="custom-control custom-switch custom-switch-md">
                    <input type="checkbox" class="custom-control-input" id="pos_seller_switch" <?= $pos_activation_for_seller == 1 ? 'checked' : '' ?> onchange="togglePosActivation(this)">
                    <label class="custom-control-label fw-600" for="pos_seller_switch">Enable POS for Sellers</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Thermal Printer Size Card -->
    <div class="col-lg-4 mb-4">
        <div class="card border">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fs-15 fw-700 text-dark">Thermal Printer Size</h5>
            </div>
            <div class="card-body py-4">
                <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                    <div class="form-group">
                        <label class="fs-12 text-secondary">Print Width (mm)</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="print_width" placeholder="Print width in mm" value="<?= esc($print_width) ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">mm</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary btn-sm fw-600 px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePosActivation(el) {
    let status = el.checked ? 1 : 0;
    alert('POS Activation setting updated to ' + (status ? 'Enabled' : 'Disabled'));
}
</script>

<?= view('admin/layouts/footer') ?>
