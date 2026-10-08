<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?= esc($page_title) ?></h1>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">Product Bulk Upload</h5>
    </div>
    <div class="card-body">
        <div class="alert mb-3" style="color: #004085; background-color: #cce5ff; border-color: #b8daff;">
            <p class="mb-1">1. Download the skeleton file and fill it with proper data.</p>
            <p class="mb-1">2. You can download the example file to understand how the data must be filled.</p>
            <p class="mb-1">3. Category, Brand, Flash Sale, Unit, Note, Warranty, Color, Attribute and Attribute Values should be in numerical ID format.</p>
            <p class="mb-1">4. You can find all IDs in the separate reference sheets inside the downloaded file.</p>
            <p class="mb-1">5. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.</p>
            <p class="mb-0">6. After uploading products, you need to edit them to attach product images and set choices.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/products/bulk-demo-download') ?>" class="btn btn-info">
                <i class="las la-download mr-1"></i> Download CSV with Reference Data
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">Upload Product File</h5>
    </div>
    <div class="card-body">
        <form class="form-horizontal" action="<?= base_url('admin/products/bulk-upload') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label class="col-sm-3 col-from-label">CSV File <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <label class="custom-file-label">
                            <input type="file" name="bulk_file" class="custom-file-input" required accept=".csv, .xlsx, .xls">
                            <span class="custom-file-name">Choose File</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">Upload CSV</button>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
