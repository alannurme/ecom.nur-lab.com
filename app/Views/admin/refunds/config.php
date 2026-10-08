<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Refund Configuration</h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Global Refund Settings</h5>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="form-group row">
                    <label class="col-md-4 col-from-label">Allow Refund Request</label>
                    <div class="col-md-8">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="allow_refund_request" value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-from-label">Refund Time Limit (Days)</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" name="refund_time_limit" value="7" min="1">
                        <small class="text-muted">Customers can request a refund within this specified days after delivery.</small>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
