<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="aiz-titlebar text-left pb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-bold mb-0">All products</h1>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <!-- Nav Tab Header & Add New Button -->
    <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom border-light px-4 py-3 table-nav-tabs">
        <div class="table-tabs-container flex-grow-1">
<?php $currentType = $type ?? 'all'; ?>
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?= $currentType === 'all' ? 'active text-primary fw-600' : 'text-secondary fw-500' ?> px-3 pb-2 fs-14 border-0" href="<?= base_url('admin/products') ?>">
                        All Products (<?= count($products) ?>)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentType === 'inhouse' ? 'active text-primary fw-600' : 'text-secondary fw-500' ?> px-3 pb-2 fs-14 border-0" href="<?= base_url('admin/products/inhouse') ?>">
                        In House Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentType === 'seller' ? 'active text-primary fw-600' : 'text-secondary fw-500' ?> px-3 pb-2 fs-14 border-0" href="<?= base_url('admin/products/seller') ?>">
                        Seller Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentType === 'digital' ? 'active text-primary fw-600' : 'text-secondary fw-500' ?> px-3 pb-2 fs-14 border-0" href="<?= base_url('admin/products/digital') ?>">
                        Digital Products
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary rounded-pill px-4 fw-600">
                <i class="las la-plus mr-1"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card-header row border-0 py-3 px-4 align-items-center">
        <div class="col-md-4 mb-2 mb-md-0">
            <div class="input-group bg-light rounded-1 border border-light">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-transparent text-muted">
                        <i class="las la-search"></i>
                    </span>
                </div>
                <input type="text" id="search-input" class="form-control form-control-sm border-0 bg-transparent" placeholder="Search products...">
            </div>
        </div>

        <div class="col-md-8 d-flex justify-content-end align-items-center flex-wrap">
            <!-- Bulk Action -->
            <div class="dropdown mr-2 mb-2 mb-md-0">
                <button class="btn btn-soft-secondary dropdown-toggle fs-14 fw-500" type="button" data-toggle="dropdown">
                    Bulk Action
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item text-secondary fs-14" href="javascript:void(0);">Publish</a>
                    <a class="dropdown-item text-secondary fs-14" href="javascript:void(0);">Mark Featured</a>
                    <a class="dropdown-item text-secondary fs-14" href="javascript:void(0);">Mark Todays Deal</a>
                    <a class="dropdown-item text-danger fs-14" href="javascript:void(0);">Delete</a>
                </div>
            </div>

            <!-- Filter -->
            <div class="dropdown mr-2 mb-2 mb-md-0">
                <button class="btn btn-soft-secondary dropdown-toggle fs-14 fw-500" type="button" data-toggle="dropdown">
                    Filter
                </button>
                <div class="dropdown-menu dropdown-menu-right p-3 w-200px">
                    <div class="form-check py-1">
                        <input class="form-check-input" type="checkbox" id="filter-all" checked>
                        <label class="form-check-label fs-14" for="filter-all">All</label>
                    </div>
                    <div class="form-check py-1">
                        <input class="form-check-input" type="checkbox" id="filter-published">
                        <label class="form-check-label fs-14" for="filter-published">All Published</label>
                    </div>
                    <div class="form-check py-1">
                        <input class="form-check-input" type="checkbox" id="filter-discount">
                        <label class="form-check-label fs-14" for="filter-discount">All Discounted</label>
                    </div>
                </div>
            </div>

            <!-- Sort -->
            <div class="w-180px mb-2 mb-md-0">
                <select class="form-control aiz-selectpicker" id="sort-select">
                    <option value="">Sort By</option>
                    <option value="price_high">Base Price (High > Low)</option>
                    <option value="price_low">Base Price (Low > High)</option>
                    <option value="sales_high">Num of Sale (High > Low)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table aiz-table mb-0 align-items-center">
                <thead>
                    <tr class="fs-12 text-secondary bg-light border-bottom">
                        <th class="w-40px pl-4">
                            <label class="aiz-checkbox mb-0">
                                <input type="checkbox" id="select-all">
                                <span class="aiz-square-check"></span>
                            </label>
                        </th>
                        <th>Product Name</th>
                        <th>Added By</th>
                        <th>Info</th>
                        <th>Total Stock</th>
                        <th>Todays Deal</th>
                        <th>Published</th>
                        <th>Featured</th>
                        <th class="text-right pr-4">Options</th>
                    </tr>
                </thead>
                <tbody id="products-table-body">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $prod): ?>
                            <tr class="border-bottom">
                                <td class="pl-4">
                                    <label class="aiz-checkbox mb-0">
                                        <input type="checkbox" class="select-one" value="<?= $prod['id'] ?>">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= !empty($prod['thumbnail_path']) ? base_url($prod['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>" 
                                             alt="" width="48" height="48" class="rounded border mr-3" style="object-fit: cover;" 
                                             onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                        <div>
                                            <span class="fw-700 text-dark d-block fs-14"><?= esc($prod['name']) ?></span>
                                            <span class="fs-12 text-muted"><?= esc($prod['category_name'] ?? 'General') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-inline badge-soft-info border fw-600">Admin</span>
                                </td>
                                <td>
                                    <span class="fs-13 d-block">Base Price: <strong class="text-primary">৳<?= number_format($prod['unit_price'], 2) ?></strong></span>
                                    <span class="fs-12 text-muted">Rating: 5.0 (0 reviews)</span>
                                </td>
                                <td>
                                    <span class="fs-14 fw-700 text-dark"><?= esc($prod['current_stock'] ?? 10) ?></span>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($prod['todays_deal'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($prod['published'] ?? 1) == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($prod['featured'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-right pr-4">
                                    <a href="<?= base_url('admin/products/edit/' . $prod['id']) ?>" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-warning btn-icon btn-circle btn-sm mr-1" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('select-all')?.addEventListener('change', function() {
    var checkboxes = document.querySelectorAll('.select-one');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
});
</script>

<?= view('admin/layouts/footer') ?>
