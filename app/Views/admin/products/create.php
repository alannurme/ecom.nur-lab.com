<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 fw-700">Add New Product</h1>
        </div>
        <div class="col text-right">
            <a class="btn btn-xs btn-soft-primary" href="javascript:void(0);" onclick="location.reload();">
                Clear Tempdata
            </a>
            <a class="btn btn-xs btn-soft-warning ml-2" href="<?= base_url('admin/products') ?>">
                All Products
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem add-product-page-content mb-4">
    <input type="hidden" id="data_type" value="physical">

    <form action="<?= base_url('admin/products/store') ?>" method="POST" enctype="multipart/form-data" id="aizSubmitForm">
        <?= csrf_field() ?>

        <div class="row">
            <!-- Left 8 Columns -->
            <div class="col-xl-8">

                <!-- 1. Product Basic Information -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4" id="basic-information">
                    <div class="mb-3 pb-1 d-flex align-items-center justify-content-between border-bottom-dashed">
                        <h5 class="fs-16 fw-700 mb-0">Product Basic Information</h5>
                        <a href="javascript:void(0)" class="d-flex align-items-center bg-transparent border-0">
                            <i class="las la-magic text-primary fs-18"></i>
                            <h5 class="fs-14 fw-700 text-primary mb-0 ml-2">Generate with AI</h5>
                        </a>
                    </div>
                    <div class="row gutters-5">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Select Main Category <span class="text-danger">*</span></label>
                                <select class="form-control aiz-selectpicker" name="category_id" id="category_id" data-live-search="true" required>
                                    <option value="">Select Main Category</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Brand</label>
                                <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                                    <option value="">Select Brand</option>
                                    <?php if (!empty($brands)): ?>
                                        <?php foreach ($brands as $brand): ?>
                                            <option value="<?= $brand['id'] ?>"><?= esc($brand['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Product Configuration -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4" id="product-configuration">
                    <div class="mb-3 pb-1 border-bottom-dashed d-flex align-items-center justify-content-between">
                        <h5 class="fs-16 fw-700 mb-0">Product Configuration</h5>
                        <a href="javascript:void(0)" class="d-flex align-items-center bg-transparent border-0">
                            <i class="las la-magic text-primary fs-18"></i>
                            <h5 class="fs-14 fw-700 text-primary mb-0 ml-2">Generate</h5>
                        </a>
                    </div>
                    <div class="row gutters-5">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Unit</label>
                                <input type="text" class="form-control" name="unit" placeholder="Unit (e.g. KG, Pc)" value="Pc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Weight (In Kg)</label>
                                <input type="number" step="0.001" class="form-control" name="weight" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Minimum Purchase Qty *</label>
                                <input type="number" class="form-control" name="min_qty" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="col-from-label fs-14 fw-500">Barcode</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Barcode">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-dark text-white px-3" onclick="document.getElementById('barcode').value = Math.floor(100000000000 + Math.random() * 900000000000);">Generate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label class="col-from-label fs-14 fw-500">Tags *</label>
                                <input type="text" class="form-control aiz-tag-input" name="tags" placeholder="Type and hit enter to add a tag">
                                <small class="text-muted">This is used for search. Input words by which cutomer can find this product.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Files & Media -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <div class="mb-3 pb-1 border-bottom-dashed">
                        <h5 class="fs-16 fw-700 mb-0">Files & Media</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Thumbnail Image (300px X 300px)</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail_img" class="custom-file-input" id="thumbnail_img">
                                <label class="custom-file-label" for="thumbnail_img">Choose Thumbnail</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Gallery Images (800px X 800px)</label>
                            <div class="custom-file">
                                <input type="file" name="photos[]" multiple class="custom-file-input" id="photos">
                                <label class="custom-file-label" for="photos">Choose Gallery Images</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-from-label fs-14 fw-500">Youtube video / shorts link</label>
                            <small class="d-block text-muted mb-2">Paste a YouTube video or Shorts URL. The video will be displayed and playable on the product page.</small>
                            <input type="text" class="form-control" name="video_link" placeholder="Paste url here">
                        </div>
                        <div class="col-12">
                            <label class="col-from-label fs-14 fw-500">PDF Specification Document</label>
                            <div class="custom-file">
                                <input type="file" name="pdf" class="custom-file-input" id="pdf">
                                <label class="custom-file-label" for="pdf">Choose PDF File</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Product Description -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4" id="product-description">
                    <div class="mb-3 pb-1 border-bottom-dashed d-flex align-items-center justify-content-between">
                        <h5 class="fs-16 fw-700 mb-0">Product Description</h5>
                        <a href="javascript:void(0)" class="d-flex align-items-center bg-transparent border-0">
                            <i class="las la-magic text-primary fs-18"></i>
                            <h5 class="fs-14 fw-700 text-primary mb-0 ml-2">Generate</h5>
                        </a>
                    </div>
                    <div class="form-group mb-0">
                        <textarea class="form-control aiz-text-editor" name="description" rows="8" placeholder="Type product description..."></textarea>
                    </div>
                </div>

                <!-- 5. SEO Meta Tags -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4" id="product-seo-meta-tag">
                    <div class="mb-3 pb-1 border-bottom-dashed d-flex align-items-center justify-content-between">
                        <h5 class="fs-16 fw-700 mb-0">SEO Meta Tags</h5>
                        <a href="javascript:void(0)" class="d-flex align-items-center bg-transparent border-0">
                            <i class="las la-magic text-primary fs-18"></i>
                            <h5 class="fs-14 fw-700 text-primary mb-0 ml-2">Generate</h5>
                        </a>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Description</label>
                        <textarea name="meta_description" rows="4" class="form-control" placeholder="Meta Description"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Meta Image</label>
                        <div class="custom-file">
                            <input type="file" name="meta_img" class="custom-file-input" id="meta_img">
                            <label class="custom-file-label" for="meta_img">Choose Meta Image</label>
                        </div>
                    </div>
                </div>

                <!-- 6. Product Price & Variation Stock -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <div class="mb-3 pb-1 border-bottom-dashed">
                        <h5 class="fs-16 fw-700 mb-0">Product Price & Stock</h5>
                    </div>
                    
                    <!-- Colors & Variation Options -->
                    <h6 class="fs-14 fw-700 mb-3">Product Variation Configuration</h6>
                    <div class="form-group row gutters-5 align-items-center mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="Colors" disabled>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="colors[]" id="colors" multiple data-live-search="true">
                                <option value="#000000">Black</option>
                                <option value="#ffffff">White</option>
                                <option value="#ff0000">Red</option>
                                <option value="#0000ff">Blue</option>
                                <option value="#008000">Green</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" name="colors_active" value="1">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row gutters-5 align-items-center mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="Attributes" disabled>
                        </div>
                        <div class="col-md-9">
                            <select name="choice_attributes[]" id="choice_attributes" class="form-control aiz-selectpicker" multiple data-placeholder="Choose Attributes">
                                <option value="size">Size</option>
                                <option value="fabric">Fabric</option>
                                <option value="wheel">Wheel Size</option>
                            </select>
                        </div>
                    </div>

                    <div class="row gutters-5 mt-4">
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Unit Price *</label>
                            <input type="number" step="0.01" min="0" value="0" placeholder="Unit price" name="unit_price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Purchase Price</label>
                            <input type="number" step="0.01" min="0" value="0" placeholder="Purchase price" name="purchase_price" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Discount Date Range</label>
                            <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date Range">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Discount</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" name="discount" value="0" placeholder="0.00">
                                <div class="input-group-append">
                                    <select class="form-control aiz-selectpicker" name="discount_type">
                                        <option value="flat">Flat</option>
                                        <option value="percent" selected>Percent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Current Stock *</label>
                            <input type="number" name="current_stock" class="form-control" value="10" placeholder="10" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-from-label fs-14 fw-500">SKU</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="Product SKU">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-dark text-white px-3" onclick="document.getElementById('sku').value = 'SKU-' + Math.floor(100000 + Math.random() * 900000);">Generate</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Product External Link</label>
                            <input type="text" placeholder="External link" name="external_link" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Link Button Text</label>
                            <input type="text" placeholder="External link button text" name="external_link_btn" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- 7. Frequently Bought Together -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Frequently Bought Together</h5>
                    <div class="d-flex mb-3">
                        <div class="custom-control custom-radio mr-4">
                            <input type="radio" id="fq_prod" name="frequently_bought_selection_type" value="product" class="custom-control-input" checked>
                            <label class="custom-control-label fs-14 fw-600" for="fq_prod">Select Product</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="fq_cat" name="frequently_bought_selection_type" value="category" class="custom-control-input">
                            <label class="custom-control-label fs-14 fw-600" for="fq_cat">Select Category</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-block border border-dashed text-primary fs-14 rounded-2 py-2">
                        <i class="las la-plus mr-1"></i> Add Frequently Bought Item
                    </button>
                </div>

            </div>

            <!-- Right 4 Columns -->
            <div class="col-xl-4">

                <!-- Related Categories -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Related Categories</h5>
                    <div class="form-group mb-0">
                        <select class="form-control aiz-selectpicker" name="category_ids[]" id="category_ids" multiple data-live-search="true" data-selected-text-format="count" title="Select Related Categories" style="min-height: 120px;">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Publish & Status -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Publish & Status</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Publish Product</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="published" value="1" checked>
                            <span></span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Featured</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="featured" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Todays Deal</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="todays_deal" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Flash Deal Campaign</label>
                        <select class="form-control aiz-selectpicker" name="flash_deal_id">
                            <option value="">Choose Flash Deal</option>
                            <option value="1">Mega Winter Sale</option>
                            <option value="2">Flash Deal Electronics</option>
                        </select>
                    </div>
                </div>

                <!-- Refund & Warranty -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Refund & Warranty</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Refundable</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="refundable" value="1" checked>
                            <span></span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Enable Warranty</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="has_warranty" value="1">
                            <span></span>
                        </label>
                    </div>
                </div>

                <!-- Shipping Configuration -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Shipping Configuration</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Free Shipping</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="free_shipping" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Flat Rate Shipping Fee</label>
                        <input type="number" step="0.01" class="form-control" name="flat_shipping_cost" placeholder="0.00">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fs-14 fw-500">Is Product Quantity Multiply</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="is_quantity_multiplied" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Estimate Shipping Days</label>
                        <input type="text" class="form-control" name="est_shipping_days" placeholder="e.g. 3-5 days">
                    </div>
                </div>

                <!-- Vat & Tax -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Vat & TAX</h5>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Tax</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" value="0" name="tax" class="form-control" placeholder="Tax">
                            <div class="input-group-append">
                                <select class="form-control aiz-selectpicker" name="tax_type">
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cash On Delivery -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Cash On Delivery</h5>
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <span class="fs-14 fw-500">Status</span>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="cash_on_delivery" value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div>

                <!-- Stock & Display Settings -->
                <div class="border border-gray-300 rounded-2 bg-white px-3 px-lg-4 py-3 py-lg-4 mb-4">
                    <h5 class="fs-16 fw-700 border-bottom-dashed mb-3 pb-2">Stock & Display Settings</h5>
                    <div class="form-group mb-2">
                        <div class="radio mar-btm mb-2">
                            <input id="stock_hide" type="radio" name="stock_visibility_state" value="hide" checked>
                            <label for="stock_hide" class="fs-14 fw-500 ml-1">Hide Stock State</label>
                        </div>
                        <div class="radio mar-btm mb-2">
                            <input id="stock_qty" type="radio" name="stock_visibility_state" value="quantity">
                            <label for="stock_qty" class="fs-14 fw-500 ml-1">Show Stock Quantity</label>
                        </div>
                        <div class="radio mar-btm">
                            <input id="stock_text" type="radio" name="stock_visibility_state" value="text">
                            <label for="stock_text" class="fs-14 fw-500 ml-1">Show Stock With Text Only</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sticky Footer Buttons Bar -->
        <div class="mt-4 text-right bg-white p-3 border rounded-2 shadow-sm d-flex justify-content-end align-items-center">
            <button type="submit" name="button" value="unpublish" class="btn btn-soft-secondary px-4 fw-700 mr-2">Save & Unpublish</button>
            <button type="submit" name="button" value="publish" class="btn btn-success px-4 fw-700 mr-2">Save & Publish</button>
            <button type="submit" name="button" value="draft" class="btn btn-dark px-4 fw-700">Save as Draft</button>
        </div>
    </form>
</div>

<?= $this->include('admin/layouts/footer') ?>
