<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="aiz-titlebar text-left pb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-bold mb-0">Auction Products Orders</h1>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header border-bottom-0 row opacity-100">
        <div class="col-md-6">
            <h5 class="mb-0 h6">Auction Orders (<?= count($orders) ?>)</h5>
        </div>
        <div class="col-md-6">
            <form action="" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search Order Code...">
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
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Delivery Status</th>
                    <th>Payment Status</th>
                    <th class="text-right">Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $key => $o): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><span class="fw-700"><?= esc($o['code'] ?? '') ?></span></td>
                            <td><?= esc($o['customer_name'] ?? 'Guest') ?></td>
                            <td>$<?= number_format($o['grand_total'] ?? 0, 2) ?></td>
                            <td><span class="badge badge-inline badge-info"><?= esc($o['delivery_status'] ?? 'Pending') ?></span></td>
                            <td><span class="badge badge-inline badge-success"><?= esc($o['payment_status'] ?? 'Paid') ?></span></td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-info btn-icon btn-circle btn-sm" title="View">
                                    <i class="las la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No auction orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
