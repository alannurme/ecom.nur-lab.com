<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700"><?= esc($page_title ?? 'Setup Configuration') ?></h1>
    <span class="fs-13 text-muted">Configure and manage setup settings</span>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold"><?= esc($page_title ?? 'Settings') ?></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-group row align-items-center mb-4">
                    <label class="col-md-3 col-form-label fs-14 fw-500">Enable Feature</label>
                    <div class="col-md-9">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="status" value="1" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-md-3 col-form-label fs-14 fw-500">Configuration Detail / Keys</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="config_value" value="Default Config Value" placeholder="Enter configuration value">
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
