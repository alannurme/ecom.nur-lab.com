<?= $this->include('admin/layouts/header') ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header border-bottom-0 pt-4 pb-2">
                <h5 class="mb-0 fw-700">Select Shipping Method</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/setup/shipping/configuration/update') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="type" value="shipping_type">

                    <div class="radio mar-btm">
                        <input id="product_shipping" class="magic-radio" type="radio" name="shipping_type" value="product_wise" <?php if($shipping_type == 'product_wise') echo 'checked';?>>
                        <label for="product_shipping" class="fw-600">
                            <span>Product Wise Shipping Cost</span>
                            <span class="d-block fs-11 text-muted">Shipping cost is calculated by Addition of each product shipping cost</span>
                        </label>
                    </div>
                    
                    <div class="radio mar-btm">
                        <input id="flat_shipping" class="magic-radio" type="radio" name="shipping_type" value="flat_rate" <?php if($shipping_type == 'flat_rate') echo 'checked';?>>
                        <label for="flat_shipping" class="fw-600">
                            <span>Flat Rate Shipping Cost</span>
                            <span class="d-block fs-11 text-muted">Shipping cost is calculated by flat amount per order</span>
                        </label>
                    </div>

                    <div class="radio mar-btm">
                        <input id="seller_shipping" class="magic-radio" type="radio" name="shipping_type" value="seller_wise" <?php if($shipping_type == 'seller_wise') echo 'checked';?>>
                        <label for="seller_shipping" class="fw-600">
                            <span>Seller Wise Flat Shipping Cost</span>
                            <span class="d-block fs-11 text-muted">Shipping cost is calculated by flat amount per seller per order</span>
                        </label>
                    </div>

                    <div class="radio mar-btm">
                        <input id="area_shipping" class="magic-radio" type="radio" name="shipping_type" value="area_wise" <?php if($shipping_type == 'area_wise') echo 'checked';?>>
                        <label for="area_shipping" class="fw-600">
                            <span>Area Wise Flat Shipping Cost</span>
                            <span class="d-block fs-11 text-muted">Shipping cost is calculated by flat amount based on area</span>
                        </label>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600 shadow-sm">Save Configuration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header border-bottom-0 pt-4 pb-2">
                <h5 class="mb-0 fw-700">Flat Rate Cost</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/setup/shipping/configuration/update') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="type" value="flat_rate_shipping_cost">

                    <div class="form-group mb-4">
                        <label class="form-label fw-600 text-dark">Amount</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" name="flat_rate_shipping_cost" class="form-control" value="<?= htmlspecialchars($flat_rate_shipping_cost) ?>" placeholder="0.00">
                            <div class="input-group-append">
                                <span class="input-group-text bg-light border-left-0">BDT</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600 shadow-sm">Save Configuration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
