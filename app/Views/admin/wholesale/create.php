<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Add New Wholesale Product</h1>
        </div>
        <div class="col text-right">
            <a class="btn btn-xs btn-soft-warning ml-2" href="<?= base_url('admin/wholesale/all-products') ?>">
                All Wholesale Products
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <form class="form form-horizontal mar-top" action="<?= base_url('admin/products/store') ?>" method="POST" enctype="multipart/form-data" id="choice_form">
        <?= csrf_field() ?>
        <input type="hidden" name="added_by" value="admin">
        <input type="hidden" name="is_wholesale" value="1">

        <div class="row gutters-5">
            <!-- Left 8 Columns -->
            <div class="col-lg-8">
                
                <!-- Product Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                            </div>
                        </div>

                        <div class="form-group row" id="brand">
                            <label class="col-md-3 col-from-label">Brand</label>
                            <div class="col-md-8">
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

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit" placeholder="Unit (e.g. KG, Pc etc)" value="Pc" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Minimum Purchase Qty <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="min_qty" value="1" min="1" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tags <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control aiz-tag-input" name="tags[]" placeholder="Type and hit enter to add a tag">
                                <small class="text-muted">This is used for search. Input those words by which customer can find this product.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Barcode</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="barcode" placeholder="Barcode">
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
                    </div>
                </div>

                <!-- Product Images -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <!-- Thumbnail Image -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Thumbnail Image <small>(300x300)</small></label>
                            <div class="col-md-8">
                                <div class="mb-3" id="thumb_preview_container" style="display:none;">
                                    <div class="p-2 border rounded bg-white d-inline-block shadow-sm">
                                        <img src="" class="img-fit rounded" id="thumb_preview_img" style="max-height: 150px; max-width: 280px;" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <div class="d-inline-block">
                                        <input type="hidden" name="thumbnail_img_id" id="selected_thumb_id" class="selected-files" value="">
                                        <button type="button" onclick="openAizUploaderModalForProduct()" class="btn btn-primary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center" style="gap: 8px;">
                                            <i class="las la-folder-open fs-18"></i> Choose from Uploaded Files
                                        </button>
                                    </div>
                                    <div class="d-inline-block">
                                        <input type="file" name="thumbnail_img" id="thumb_file_input" class="d-none" accept="image/*" onchange="handleProductThumbUpload(this)">
                                        <button type="button" onclick="document.getElementById('thumb_file_input').click()" class="btn btn-outline-secondary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center bg-white text-dark border" style="gap: 8px; border-color: #ced4da !important;">
                                            <i class="las la-upload fs-18 text-muted"></i> Upload from PC
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Select an image from uploaded files modal or upload a new thumbnail from your PC.</small>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Gallery Images <small>(600x600)</small></label>
                            <div class="col-md-8">
                                <div class="mb-3 d-flex flex-wrap align-items-center" id="gallery_preview_container" style="gap: 12px; display: none;"></div>
                                <input type="hidden" name="photos_ids" id="selected_gallery_ids" class="selected-files" value="">
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <div class="d-inline-block">
                                        <button type="button" onclick="openAizUploaderModalForGallery()" class="btn btn-primary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center" style="gap: 8px;">
                                            <i class="las la-folder-open fs-18"></i> Choose from Uploaded Files
                                        </button>
                                    </div>
                                    <div class="d-inline-block">
                                        <input type="file" name="photos[]" id="gallery_file_input" class="d-none" accept="image/*" multiple onchange="handleProductGalleryPcUpload(this)">
                                        <button type="button" onclick="document.getElementById('gallery_file_input').click()" class="btn btn-outline-secondary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center bg-white text-dark border" style="gap: 8px; border-color: #ced4da !important;">
                                            <i class="las la-upload fs-18 text-muted"></i> Upload from PC
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Select multiple images from uploaded files modal or upload multiple new files from your PC.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Videos -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Videos</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Video Provider</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                                    <option value="youtube">Youtube</option>
                                    <option value="dailymotion">Dailymotion</option>
                                    <option value="vimeo">Vimeo</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Video Link</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="video_link" placeholder="Video Link">
                                <small class="text-muted">Use proper link without extra parameter. Don't use short share link/embeded iframe code.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Price + Stock & Wholesale Prices -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product price + stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Unit price <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" min="0" value="0" step="0.01" placeholder="Unit price" name="unit_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" min="0" value="0" step="1" placeholder="Quantity" name="current_stock" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">SKU</label>
                            <div class="col-md-6">
                                <input type="text" placeholder="SKU" name="sku" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Wholesale Prices</label>
                            <div class="col-md-9">
                                <div class="qunatity-price" id="wholesale-price-container">
                                    <div class="row gutters-5 mb-2 wholesale-row">
                                        <div class="col-3">
                                            <div class="form-group mb-0">
                                                <input type="number" class="form-control" placeholder="Min QTY" name="wholesale_min_qty[]" required>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group mb-0">
                                                <input type="number" class="form-control" placeholder="Max QTY" name="wholesale_max_qty[]" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mb-0">
                                                <input type="number" step="0.01" class="form-control" placeholder="Price per piece" name="wholesale_price[]" required>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-icon btn-circle btn-sm btn-soft-danger remove-wholesale-row">
                                                <i class="las la-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-soft-secondary btn-sm" id="add-wholesale-price-btn">
                                    Add More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Product Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control aiz-text-editor" name="description" rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PDF Specification -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">PDF Specification</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">PDF Specification</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="pdf" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Meta Tags -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">SEO Meta Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Meta Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Description</label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Meta Image</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="meta_img" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Frequently Brought Products -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Frequently Brought</h5>
                    </div>
                    <div class="w-100 p-3">
                        <div class="d-flex my-3"> 
                            <div class="align-items-center d-flex mar-btm ml-2 mr-4 radio">
                                <input id="fq_brought_select_products" type="radio" name="frequently_brought_selection_type" value="product" onchange="fq_brought_product_selection_type()" checked>
                                <label for="fq_brought_select_products" class="fs-14 fw-500 mb-0 ml-2">Select Product</label>
                            </div>
                            <div class="radio mar-btm mr-3 d-flex align-items-center">
                                <input id="fq_brought_select_category" type="radio" name="frequently_brought_selection_type" value="category" onchange="fq_brought_product_selection_type()">
                                <label for="fq_brought_select_category" class="fs-14 fw-500 mb-0 ml-2">Select Category</label>
                            </div>
                        </div>

                        <div class="fq_brought_select_product_div">
                            <div id="selected-fq-brought-products"></div>
                            <button type="button" class="btn btn-block border border-dashed hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center py-2" onclick="$('#fq-brought-product-select-modal').modal('show')">
                                <i class="las la-plus mr-2"></i>
                                <span>Add More</span>
                            </button>
                        </div>

                        <div class="fq_brought_select_category_div d-none">
                            <div class="form-group row">
                                <label class="col-md-2 col-from-label">Category</label>
                                <div class="col-md-10">
                                    <select class="form-control aiz-selectpicker" name="fq_brought_product_category_id" data-live-search="true">
                                        <option value="">Select Category</option>
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right 4 Columns Sidebar -->
            <div class="col-lg-4">

                <!-- Product Category Treeview -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 h6">Product Category</h5>
                        <small class="text-muted">Select Main</small>
                    </div>
                    <div class="card-body">
                        <div class="h-300px overflow-auto c-scrollbar-light">
                            <ul class="hummingbird-treeview-converter list-unstyled" id="treeview" data-checkbox-name="category_ids[]" data-radio-name="category_id">
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <li id="<?= $cat['id'] ?>">
                                            <label class="aiz-checkbox mb-0">
                                                <input type="checkbox" name="category_ids[]" value="<?= $cat['id'] ?>">
                                                <span class="aiz-square-check"></span>
                                                <?= esc($cat['name']) ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Shipping Configuration -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Shipping Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Free Shipping</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="shipping_type" value="free" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Flat Rate</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="shipping_type" value="flat_rate">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="flat_rate_shipping_div" style="display: none">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Shipping cost</label>
                                <div class="col-md-6">
                                    <input type="number" min="0" value="0" step="0.01" placeholder="Shipping cost" name="flat_shipping_cost" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Is Product Quantity Multiplied</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="is_quantity_multiplied" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Quantity Warning -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Low Stock Quantity Warning</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label>Quantity</label>
                            <input type="number" name="low_stock_quantity" value="1" min="0" step="1" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Stock Visibility State -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Stock Visibility State</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Show Stock Quantity</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="quantity" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Show Stock With Text Only</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="text">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Hide Stock</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="hide">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cash On Delivery -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Cash On Delivery</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="cash_on_delivery" value="1" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Featured</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="featured" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Todays Deal -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Todays Deal</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">Status</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="todays_deal" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Deal -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Flash Deal</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label>Add To Flash</label>
                            <select class="form-control aiz-selectpicker" name="flash_deal_id" id="flash_deal">
                                <option value="">Choose Flash Title</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Discount</label>
                            <input type="number" name="flash_discount" value="0" min="0" step="1" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>Discount Type</label>
                            <select class="form-control aiz-selectpicker" name="flash_discount_type" id="flash_discount_type">
                                <option value="">Choose Discount Type</option>
                                <option value="amount">Flat</option>
                                <option value="percent">Percent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Estimate Shipping Time -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Estimate Shipping Time</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label>Shipping Days</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="est_shipping_days" min="1" step="1" placeholder="Shipping Days">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VAT & Tax -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">VAT & Tax</h5>
                    </div>
                    <div class="card-body">
                        <label>Vat / Tax</label>
                        <input type="hidden" value="1" name="tax_id[]">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <input type="number" min="0" value="0" step="0.01" placeholder="Tax" name="tax[]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <select class="form-control aiz-selectpicker" name="tax_type[]">
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Buttons -->
            <div class="col-12">
                <div class="btn-toolbar float-right mb-4" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <button type="submit" name="button" value="unpublish" class="btn btn-primary px-4">Save & Unpublish</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" name="button" value="publish" class="btn btn-success px-4">Save & Publish</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Frequently Brought Product Select Modal -->
<div class="modal fade" id="fq-brought-product-select-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Frequently Brought Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search product name..." id="fq_search_key">
                </div>
                <div id="product-list" class="c-scrollbar-light style-2 max-h-300px overflow-auto">
                    <p class="text-muted text-center py-3">Type above to search products...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Add Selected</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('wholesale-price-container');
    const addBtn = document.getElementById('add-wholesale-price-btn');

    if (addBtn && container) {
        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'row gutters-5 mb-2 wholesale-row';
            div.innerHTML = `
                <div class="col-3">
                    <div class="form-group mb-0">
                        <input type="number" class="form-control" placeholder="Min QTY" name="wholesale_min_qty[]" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group mb-0">
                        <input type="number" class="form-control" placeholder="Max QTY" name="wholesale_max_qty[]" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-0">
                        <input type="number" step="0.01" class="form-control" placeholder="Price per piece" name="wholesale_price[]" required>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-icon btn-circle btn-sm btn-soft-danger remove-wholesale-row">
                        <i class="las la-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-wholesale-row')) {
                const row = e.target.closest('.wholesale-row');
                if (row && container.children.length > 1) {
                    row.remove();
                }
            }
        });
    }

    // Toggle flat rate shipping
    const shippingRadios = document.querySelectorAll('input[name="shipping_type"]');
    const flatRateDiv = document.querySelector('.flat_rate_shipping_div');
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (flatRateDiv) {
                flatRateDiv.style.display = (this.value === 'flat_rate') ? 'block' : 'none';
            }
        });
    });
});

function fq_brought_product_selection_type() {
    const type = document.querySelector("input[name='frequently_brought_selection_type']:checked").value;
    const prodDiv = document.querySelector('.fq_brought_select_product_div');
    const catDiv = document.querySelector('.fq_brought_select_category_div');
    if (type === 'product') {
        prodDiv.classList.remove('d-none');
        catDiv.classList.add('d-none');
    } else {
        catDiv.classList.remove('d-none');
        prodDiv.classList.add('d-none');
    }
}

function handleProductThumbUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('thumb_preview_img');
            if (img) img.src = e.target.result;
            var container = document.getElementById('thumb_preview_container');
            if (container) container.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

var uploaderTargetMode = 'thumb';
var selectedThumbFileId = null;
var selectedThumbFileUrl = null;
var selectedGalleryFiles = {};

function openAizUploaderModalForProduct() {
    uploaderTargetMode = 'thumb';
    openAizUploaderModal();
}

function openAizUploaderModalForGallery() {
    uploaderTargetMode = 'gallery';
    openAizUploaderModal();
}

function openAizUploaderModal() {
    if ($('#aizUploaderModal').length === 0) {
        $.ajax({
            url: '<?= base_url('aiz-uploader') ?>',
            type: 'GET',
            success: function(html) {
                $('body').append(html);
                loadProductUploaderFiles();
                $('#aizUploaderModal').modal('show');
            },
            error: function(err) {
                console.error(err);
                alert('Could not load uploader modal.');
            }
        });
    } else {
        loadProductUploaderFiles();
        $('#aizUploaderModal').modal('show');
    }
}

function loadProductUploaderFiles() {
    var search = $('#aiz-uploader-search').val() || '';
    $.ajax({
        url: '<?= base_url('aiz-uploader/get-uploaded-files') ?>',
        type: 'GET',
        data: { search: search },
        success: function(res) {
            var files = res.data || [];
            var html = '';
            if (files.length > 0) {
                files.forEach(function(file) {
                    var imgUrl = '<?= base_url() ?>' + file.file_name;
                    var isSelected = false;
                    if (uploaderTargetMode === 'thumb') {
                        isSelected = (selectedThumbFileId == file.id);
                    } else {
                        isSelected = !!selectedGalleryFiles[file.id];
                    }
                    var borderClass = isSelected ? 'border-primary shadow-sm' : '';
                    var badgeStyle = isSelected ? '' : 'display:none;';

                    html += `
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <div class="card h-100 uploader-file-card border text-center p-2 cursor-pointer position-relative ${borderClass}" data-id="${file.id}" data-url="${imgUrl}" onclick="selectProductUploaderFile(this)">
                                <div class="img-fit h-100px w-100 rounded mb-2 overflow-hidden d-flex align-items-center justify-content-center bg-light">
                                    <img src="${imgUrl}" class="img-fluid rounded" style="max-height: 90px;" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                </div>
                                <div class="text-truncate fs-11 fw-600 text-dark">${file.file_original_name}</div>
                                <div class="selected-badge position-absolute top-0 right-0 p-1" style="${badgeStyle}">
                                    <span class="badge badge-primary rounded-circle"><i class="las la-check"></i></span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = '<div class="col-12 text-center py-4 text-muted">No uploaded files found.</div>';
            }
            $('.aiz-uploader-selecte-file-list').html(html);
        }
    });
}

function selectProductUploaderFile(el) {
    var id = $(el).data('id');
    var url = $(el).data('url');

    if (uploaderTargetMode === 'thumb') {
        $('.uploader-file-card').removeClass('border-primary shadow-sm').find('.selected-badge').hide();
        $(el).addClass('border-primary shadow-sm').find('.selected-badge').show();
        selectedThumbFileId = id;
        selectedThumbFileUrl = url;
        $('.aiz-uploader-selected').text('1');
    } else {
        if ($(el).hasClass('border-primary')) {
            $(el).removeClass('border-primary shadow-sm').find('.selected-badge').hide();
            delete selectedGalleryFiles[id];
        } else {
            $(el).addClass('border-primary shadow-sm').find('.selected-badge').show();
            selectedGalleryFiles[id] = url;
        }
        $('.aiz-uploader-selected').text(Object.keys(selectedGalleryFiles).length);
    }
}

$(document).on('click', '[data-toggle="aizUploaderAddSelected"]', function() {
    if (uploaderTargetMode === 'thumb') {
        if (selectedThumbFileId && selectedThumbFileUrl) {
            $('#selected_thumb_id').val(selectedThumbFileId);
            $('#thumb_preview_img').attr('src', selectedThumbFileUrl);
            $('#thumb_preview_container').show();
        }
    } else {
        var currentIds = $('#selected_gallery_ids').val() ? $('#selected_gallery_ids').val().split(',') : [];
        for (var id in selectedGalleryFiles) {
            if (!currentIds.includes(String(id))) {
                currentIds.push(id);
                appendGalleryPreviewCard(id, selectedGalleryFiles[id]);
            }
        }
        $('#selected_gallery_ids').val(currentIds.join(','));
        if (currentIds.length > 0) {
            $('#gallery_preview_container').css('display', 'flex');
        }
        selectedGalleryFiles = {};
    }
    $('#aizUploaderModal').modal('hide');
});

function appendGalleryPreviewCard(id, url) {
    var html = `
        <div class="position-relative p-2 border rounded bg-white shadow-sm gallery-item-card" data-id="${id}" style="width: 120px; height: 120px;">
            <img src="${url}" class="img-fit rounded w-100 h-100">
            <button type="button" class="btn btn-sm btn-danger rounded-circle position-absolute" style="top: -6px; right: -6px; width: 24px; height: 24px; padding: 0; line-height: 24px; text-align: center;" onclick="removeGalleryItem(this, '${id}')">&times;</button>
        </div>
    `;
    $('#gallery_preview_container').append(html);
    $('#gallery_preview_container').css('display', 'flex');
}

function removeGalleryItem(btn, id) {
    $(btn).closest('.gallery-item-card').remove();
    var currentIds = $('#selected_gallery_ids').val() ? $('#selected_gallery_ids').val().split(',') : [];
    currentIds = currentIds.filter(function(i) { return i != id && i != ''; });
    $('#selected_gallery_ids').val(currentIds.join(','));
    if ($('#gallery_preview_container').children('.gallery-item-card').length === 0) {
        $('#gallery_preview_container').hide();
    }
}

function handleProductGalleryPcUpload(input) {
    if (input.files && input.files.length > 0) {
        for (var i = 0; i < input.files.length; i++) {
            (function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var html = `
                        <div class="position-relative p-2 border rounded bg-white shadow-sm gallery-item-card" style="width: 120px; height: 120px;">
                            <img src="${e.target.result}" class="img-fit rounded w-100 h-100">
                            <button type="button" class="btn btn-sm btn-danger rounded-circle position-absolute" style="top: -6px; right: -6px; width: 24px; height: 24px; padding: 0; line-height: 24px; text-align: center;" onclick="$(this).closest('.gallery-item-card').remove()">&times;</button>
                        </div>
                    `;
                    $('#gallery_preview_container').append(html);
                    $('#gallery_preview_container').css('display', 'flex');
                };
                reader.readAsDataURL(file);
            })(input.files[i]);
        }
    }
}
</script>

<?= $this->include('admin/layouts/footer') ?>
