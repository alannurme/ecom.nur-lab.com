<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">System Update</h1>
    <span class="fs-13 text-muted">Check and update your eCommerce system to the latest version</span>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Update System Software</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info rounded-2 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="las la-info-circle fs-24 mr-2"></i>
                            <div>
                                <strong>Current Version:</strong> v4.7.4 | <strong>Environment:</strong> CodeIgniter 4 Development
                            </div>
                        </div>
                    </div>

                    <form action="<?= base_url('admin/system/update/process') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group mb-4">
                            <label class="fs-14 fw-500">Upload Update Zip File</label>
                            <div class="custom-file">
                                <input type="file" name="update_zip" class="custom-file-input" required>
                                <label class="custom-file-label">Choose system update package (.zip)</label>
                            </div>
                            <small class="text-muted d-block mt-1">Make sure you take a full database backup before updating.</small>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Update Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
