<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Category Wise Discount</h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Set Category Discount</h5>
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
                    <label class="col-md-3 col-from-label">Discount Amount</label>
                    <div class="col-md-8">
                        <input type="number" step="0.01" class="form-control" name="discount" placeholder="Discount Amount">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">Discount Type</label>
                    <div class="col-md-8">
                        <select class="form-control aiz-selectpicker" name="discount_type">
                            <option value="flat">Flat</option>
                            <option value="percent">Percent (%)</option>
                        </select>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Apply Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
