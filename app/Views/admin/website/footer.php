<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Website Footer Setup</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Sub Footer Card -->
            <div class="card shadow-sm border-0 rounded-2 mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Sub Footer Section</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Show Full Width Sub Footer</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="show_full_width_sub_footer" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Enable Sub Footer</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="enable_sub_footer_section" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Background Color</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="sub_footer_bg_color" value="#111723">
                                    <div class="input-group-append">
                                        <span class="input-group-text p-1"><input type="color" value="#111723" class="border-0 bg-transparent cursor-pointer"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Footer Title</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="footer_title" value="About NUR-LAB ECOM">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Footer Description</label>
                            <div class="col-md-9">
                                <textarea name="footer_description" class="form-control" rows="4">Leading e-commerce solution providing high quality products, fast delivery and 24/7 dedicated customer support.</textarea>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Policy & Copyright Card -->
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Copyright & Social Links</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Copyright Text</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="frontend_copyright_text" value="© 2026 NUR-LAB ECOM. All Rights Reserved.">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Facebook URL</label>
                            <div class="col-md-9">
                                <input type="url" class="form-control" name="facebook_link" placeholder="https://facebook.com/yourpage">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Instagram URL</label>
                            <div class="col-md-9">
                                <input type="url" class="form-control" name="instagram_link" placeholder="https://instagram.com/yourpage">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Twitter / X URL</label>
                            <div class="col-md-9">
                                <input type="url" class="form-control" name="twitter_link" placeholder="https://twitter.com/yourpage">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">YouTube URL</label>
                            <div class="col-md-9">
                                <input type="url" class="form-control" name="youtube_link" placeholder="https://youtube.com/channel">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
