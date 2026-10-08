<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Delivery Boy Configuration</h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Configuration Settings</h5>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="form-group row">
                    <label class="col-md-4 col-from-label">Commission Type</label>
                    <div class="col-md-8">
                        <select class="form-control aiz-selectpicker" name="delivery_boy_commission_type">
                            <option value="fixed">Fixed Rate</option>
                            <option value="percentage">Percentage (%)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-from-label">Delivery Boy Commission Rate</label>
                    <div class="col-md-8">
                        <input type="number" step="0.01" class="form-control" name="delivery_boy_commission_rate" placeholder="0.00" value="10">
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
