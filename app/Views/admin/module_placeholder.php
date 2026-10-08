<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700"><?= esc($page_title ?? 'Module Management') ?></h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6"><?= esc($page_title ?? 'Module Management') ?></h5>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search <?= esc($page_title) ?>...">
            </div>
        </div>
        <div class="card-body">
            <div class="text-center py-5">
                <i class="las la-folder-open fs-48 text-muted mb-2"></i>
                <h6 class="text-secondary fw-600"><?= esc($page_title) ?> Page Ready</h6>
                <p class="text-muted fs-13">This section has been linked to CodeIgniter 4 controller and router.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
