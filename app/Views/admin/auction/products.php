<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="aiz-titlebar text-left pb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-bold mb-0"><?= esc($page_title) ?></h1>
        </div>
        <div class="col text-right">
            <a href="<?= base_url('admin/auction/create') ?>" class="btn btn-primary rounded-pill px-4 fw-600">
                <i class="las la-plus mr-1"></i> Add New Auction Product
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header border-bottom-0 row opacity-100">
        <div class="col-md-6">
            <h5 class="mb-0 h6">Auction Products (<?= count($products) ?>)</h5>
        </div>
        <div class="col-md-6">
            <form action="" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search Auction Products...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="las la-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Starting Bid</th>
                    <th>Total Bids</th>
                    <th>Auction End Date</th>
                    <th>Published</th>
                    <th class="text-right">Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $key => $p): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>
                                <span class="text-dark fs-14 fw-600"><?= esc($p['name']) ?></span>
                            </td>
                            <td>$<?= number_format($p['starting_bid'] ?? 0, 2) ?></td>
                            <td><span class="badge badge-inline badge-info">0 Bids</span></td>
                            <td><?= esc($p['auction_end_date'] ?? '—') ?></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" <?= (!empty($p['published']) && $p['published'] == 1) ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No auction products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
