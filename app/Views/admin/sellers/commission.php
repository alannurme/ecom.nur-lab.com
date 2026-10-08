<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Seller Commission Settings</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row gutters-15">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Seller Commission Activation</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group row align-items-center mb-3">
                            <div class="col-md-8">
                                <label class="col-from-label fs-14 fw-600 mb-0">Seller Commission Status</label>
                                <small class="d-block text-muted">Enable or disable commission collection from seller sales</small>
                            </div>
                            <div class="col-md-4 text-right">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="vendor_commission_activation" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="col-from-label fs-14 fw-500">Seller Commission Type</label>
                            <select class="form-control" name="seller_commission_type">
                                <option value="fixed_rate" selected>Fixed Rate (%)</option>
                                <option value="seller_based">Seller Based Rate</option>
                                <option value="category_based">Category Based Rate</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-from-label fs-14 fw-500">Global Seller Commission Rate (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" class="form-control" name="vendor_commission" value="10.00" placeholder="10">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-soft-secondary">%</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Configuration</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Withdrawal Minimum Limit</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-4">
                            <label class="col-from-label fs-14 fw-500">Minimum Seller Payout Amount ($)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" min="0" class="form-control" name="minimum_seller_amount_withdraw" value="50.00" placeholder="50.00">
                            </div>
                            <small class="text-muted mt-1 d-block">Minimum balance a seller must have to request a payout.</small>
                        </div>

                        <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
