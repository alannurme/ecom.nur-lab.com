<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Category Wise Refund</h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Set Category Refund Configuration</h5>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">Categories</label>
                    <div class="col-md-8">
                        <select class="form-control aiz-selectpicker" name="category_ids[]" multiple data-live-search="true">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">Refundable</label>
                    <div class="col-md-8">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="refundable" value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
