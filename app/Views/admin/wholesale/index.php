<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700"><?= esc($page_title ?? 'All Wholesale Products') ?></h1>
        </div>
        <?php if (($type ?? 'All') != 'Seller'): ?>
        <div class="col text-right">
            <a href="<?= base_url('admin/wholesale/create') ?>" class="btn btn-circle btn-info">
                <span>Add New Wholesale Product</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <form id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6"><?= esc($page_title ?? 'All Wholesale Products') ?></h5>
                </div>
                
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        Bulk Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item confirm-alert" href="javascript:void(0)" data-target="#bulk-delete-modal">Delete selection</a>
                    </div>
                </div>
                
                <?php if (($type ?? 'All') != 'In House'): ?>
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id" name="user_id">
                        <option value="">All Sellers</option>
                    </select>
                </div>
                <?php endif; ?>
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type">
                        <option value="">Sort By</option>
                        <option value="rating,desc">Rating (High > Low)</option>
                        <option value="rating,asc">Rating (Low > High)</option>
                        <option value="num_of_sale,desc">Num of Sale (High > Low)</option>
                        <option value="num_of_sale,asc">Num of Sale (Low > High)</option>
                        <option value="unit_price,desc">Base Price (High > Low)</option>
                        <option value="unit_price,asc">Base Price (Low > High)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Type & Enter">
                    </div>
                </div>
            </div>
        
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-group mb-0">
                                    <label class="aiz-checkbox mb-0">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </th>
                            <th>Name</th>
                            <?php if (($type ?? 'All') != 'In House'): ?>
                                <th data-breakpoints="lg">Added By</th>
                            <?php endif; ?>
                            <th data-breakpoints="sm">Info</th>
                            <th data-breakpoints="md">Total Stock</th>
                            <th data-breakpoints="lg">Todays Deal</th>
                            <th data-breakpoints="lg">Published</th>
                            <th data-breakpoints="lg">Featured</th>
                            <th data-breakpoints="sm" class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block mb-0">
                                        <label class="aiz-checkbox mb-0">
                                            <input type="checkbox" class="check-one" name="id[]" value="<?= $product['id'] ?>">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="<?= base_url($product['thumbnail_img'] ?? 'assets/img/placeholder.jpg') ?>" alt="Image" class="size-50px img-fit" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                        </div>
                                        <div class="col">
                                            <span class="text-muted text-truncate-2"><?= esc($product['name']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <?php if (($type ?? 'All') != 'In House'): ?>
                                    <td><?= esc($product['added_by'] ?? 'Inhouse') ?></td>
                                <?php endif; ?>
                                <td>
                                    <strong>Num of Sale:</strong> <?= esc($product['num_of_sale'] ?? 0) ?> times<br>
                                    <strong>Base Price:</strong> $<?= number_format($product['unit_price'] ?? 0, 2) ?><br>
                                    <strong>Rating:</strong> <?= esc($product['rating'] ?? 0) ?>
                                </td>
                                <td>
                                    <?= esc($product['current_stock'] ?? 0) ?>
                                    <?php if (($product['current_stock'] ?? 0) <= 5): ?>
                                        <span class="badge badge-inline badge-danger">Low</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($product['todays_deal'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($product['published'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" <?= ($product['featured'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="<?= base_url('product/'.$product['slug']) ?>" target="_blank" title="View">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="<?= base_url('admin/products/edit/'.$product['id']) ?>" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No Wholesale Products Found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="aiz-pagination mt-3">
                    <?= $pager->links('default', 'aiz_pagination') ?>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
