<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 fw-700">Add New Auction Product</h1>
        </div>
        <div class="col text-right">
            <a class="btn btn-xs btn-soft-warning ml-2" href="<?= base_url('admin/auction/all-products') ?>">
                All Auction Products
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem add-product-page-content mb-4">
    <form action="<?= base_url('admin/products/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="auction_product" value="1">

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom-0 pb-0">
                        <h5 class="mb-0 h6 fw-700">Auction Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Category <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Brand</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="brand_id">
                                    <option value="">Select Brand</option>
                                    <?php foreach ($brands as $b): ?>
                                        <option value="<?= $b['id'] ?>"><?= esc($b['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit" placeholder="Unit (e.g. KG, Pc)">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Starting Bidding Price <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" class="form-control" name="starting_bid" placeholder="Starting Price" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Auction Date Range <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control aiz-date-range" name="auction_date_range" placeholder="Select Date Range" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom-0 pb-0">
                        <h5 class="mb-0 h6 fw-700">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Gallery Images</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="photos" class="selected-files">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Thumbnail Image</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="thumbnail_img" class="selected-files">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom-0 pb-0">
                        <h5 class="mb-0 h6 fw-700">Product Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Description</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom-0 pb-0">
                        <h5 class="mb-0 h6 fw-700">Shipping Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-from-label">Free Shipping</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="shipping_type" value="free">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-from-label">Flat Rate</label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" class="form-control" name="flat_shipping_cost" placeholder="Cost">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 text-right">
            <button type="submit" class="btn btn-primary px-5 fw-700">Save Auction Product</button>
        </div>
    </form>
</div>

<?= view('admin/layouts/footer') ?>
