<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Website Header Setup</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Header Elements & Configurations</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Header Logo -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Header Logo</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="header_logo" class="custom-file-input" id="header_logo">
                                    <label class="custom-file-label" for="header_logo">Choose Header Logo Image</label>
                                </div>
                                <small class="text-muted d-block mt-1">Recommended dimensions: 244px width X 40px height.</small>
                            </div>
                        </div>

                        <!-- Sticky Header -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Enable Sticky Header</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="sticky_header" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Full Width Header -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Show Full Width Header</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="show_full_width_header" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Language Switcher -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Show Language Switcher</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="show_language_switcher" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Currency Switcher -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Show Currency Switcher</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="show_currency_switcher" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Header Navigation Links -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Header Top Nav Items</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control aiz-tag-input" name="header_nav_menu" value="Home, All Products, Flash Sale, Track Order, Help" placeholder="Type menu label and hit enter">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Header Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
