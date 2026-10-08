<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Website Appearance</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <!-- Colors Card -->
            <div class="card shadow-sm border-0 rounded-2 mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">General Theme Colors</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Website Base Color</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="base_color" value="#0099ff">
                                    <div class="input-group-append">
                                        <span class="input-group-text p-1"><input type="color" value="#0099ff" class="border-0 bg-transparent cursor-pointer"></span>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">Primary theme branding color.</small>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Website Base Hover Color</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="base_hov_color" value="#0080ff">
                                    <div class="input-group-append">
                                        <span class="input-group-text p-1"><input type="color" value="#0080ff" class="border-0 bg-transparent cursor-pointer"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Website Secondary Base Color</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="secondary_base_color" value="#ffc519">
                                    <div class="input-group-append">
                                        <span class="input-group-text p-1"><input type="color" value="#ffc519" class="border-0 bg-transparent cursor-pointer"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Save Colors</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Image Watermark Card -->
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Product Image Watermark</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Use Watermark on Uploads</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="use_image_watermark" value="1">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Watermark Type</label>
                            <div class="col-md-8">
                                <select name="image_watermark_type" class="form-control aiz-selectpicker">
                                    <option value="text" selected>Text</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Watermark Text</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="watermark_text" value="NUR-LAB ECOM">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-4 col-form-label fs-14 fw-500">Watermark Position</label>
                            <div class="col-md-8">
                                <select name="watermark_position" class="form-control aiz-selectpicker">
                                    <option value="bottom-right" selected>Bottom Right</option>
                                    <option value="bottom-left">Bottom Left</option>
                                    <option value="top-right">Top Right</option>
                                    <option value="top-left">Top Left</option>
                                    <option value="center">Center</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Save Watermark Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
