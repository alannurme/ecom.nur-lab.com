<?= $this->include('admin/layouts/header') ?>

<div class="col-12 col-sm-12 col-lg-10 mx-auto">
    <div class="aiz-titlebar text-left pb-5px">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3 fw-bold">All Categories</h1>
            </div>
        </div>
    </div>

    <div class="card">
        <!--Nav Tab -->
        <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom border-light px-25px table-nav-tabs pb-3 pb-xl-0">
            <div class="table-tabs-container flex-grow-1">
                <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-0 pb-15px fs-14 fw-500 <?= ($tab ?? 'all') == 'all' ? 'active' : '' ?>" href="<?= base_url('admin/categories?tab=all') ?>">
                            All Categories
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a class="nav-link px-0 pb-15px fs-14 fw-500 <?= ($tab ?? '') == 'physical' ? 'active' : '' ?>" href="<?= base_url('admin/categories?tab=physical') ?>">
                            Physical Categories
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a class="nav-link px-0 pb-15px fs-14 fw-500 <?= ($tab ?? '') == 'digital' ? 'active' : '' ?>" href="<?= base_url('admin/categories?tab=digital') ?>">
                            Digital Categories
                        </a>
                    </li>
                </ul>
            </div>

            <!--Right Side- Add New Button -->
            <div class="mb-3 mb-md-0">
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i> Add New Category
                </a>
            </div>
        </div>

        <!--Card Header (Search & Bulk Action) Start-->
        <div class="tab-filter-bar">
            <form id="sort_categories" action="" method="GET">
                <input type="hidden" name="tab" value="<?= esc($tab ?? 'all') ?>">
                <div class="card-header border-0 pb-0 mt-2 d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1 mr-2">
                        <div class="input-group mb-0 border border-light px-3 bg-light rounded-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-0 bg-transparent px-0" id="search">
                                    <i class="las la-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control form-control-sm border-0 px-2 bg-transparent" id="search_input" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search Categories ...">
                        </div>
                    </div>

                    <div class="dropdown mb-2 mb-md-0 bg-light mt-2 mt-md-0 rounded-1">
                        <button class="btn border dropdown-toggle border-light text-secondary fs-14 fw-400" type="button" data-toggle="dropdown">
                            Bulk Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item text-secondary fs-14 fw-500" href="javascript:void(0)">Mark Featured</a>
                            <a class="dropdown-item text-secondary fs-14 fw-500" href="javascript:void(0)">Mark Hot</a>
                            <a class="dropdown-item text-danger fs-14 fw-500" href="javascript:void(0)">Delete</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Categories Table -->
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th width="40px">
                            <div class="form-group mb-0">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" class="check-all">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Icon</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Name</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Parent Category</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Order Level</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Level</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Featured</th>
                        <th class="text-uppercase fs-11 fw-700 text-secondary">Hot Category</th>
                        <th class="text-right text-uppercase fs-11 fw-700 text-secondary">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $key => $category): ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="form-group mb-0">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="<?= $category['id'] ?>">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($category['icon_img'])): ?>
                                        <span class="avatar avatar-square avatar-xs">
                                            <img src="<?= base_url($category['icon_img']) ?>" alt="icon" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                        </span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-dark fs-14 fw-500"><?= esc($category['name']) ?></span>
                                    <?php if (!empty($category['digital']) && $category['digital'] == 1): ?>
                                        <span class="badge badge-secondary fs-12 py-1 px-10px rounded-pill ml-1">Digital</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= !empty($category['parent_name']) ? esc($category['parent_name']) : '—' ?></td>
                                <td><?= esc($category['order_level'] ?? 0) ?></td>
                                <td><?= esc($category['level'] ?? 0) ?></td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= (!empty($category['featured']) && $category['featured'] == 1) ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= (!empty($category['hot_category']) && $category['hot_category'] == 1) ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown float-right">
                                        <button class="btn btn-soft-secondary btn-icon btn-circle btn-sm dropdown-toggle no-arrow" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            <a class="dropdown-item text-secondary fs-14" href="#"><i class="las la-edit text-primary mr-2"></i> Edit</a>
                                            <a class="dropdown-item text-danger fs-14" href="#"><i class="las la-trash text-danger mr-2"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if (isset($pager)): ?>
                <div class="aiz-pagination mt-3">
                    <?= $pager->links('default', 'aiz_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
