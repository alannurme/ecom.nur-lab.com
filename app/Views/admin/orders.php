<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="card-custom">
    <div class="card-header-custom">
        <h6>Customer Orders (<?= count($orders) ?>)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr class="fs-13 text-muted">
                    <th>Order Code</th>
                    <th>Customer Name</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Date</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $ord): ?>
                        <tr>
                            <td class="fw-700 text-primary">#<?= esc($ord['code'] ?? $ord['id']) ?></td>
                            <td>
                                <strong class="d-block text-dark"><?= esc($ord['customer_name'] ?? 'Guest Customer') ?></strong>
                                <small class="text-muted"><?= esc($ord['customer_email'] ?? '') ?></small>
                            </td>
                            <td class="fw-800 text-dark">৳<?= number_format($ord['grand_total'] ?? 0, 2) ?></td>
                            <td>
                                <span class="badge badge-<?= ($ord['payment_status'] ?? '') === 'paid' ? 'success' : 'warning' ?> px-2 py-1">
                                    <?= ucfirst($ord['payment_status'] ?? 'Unpaid') ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info px-2 py-1">
                                    <?= ucfirst($ord['delivery_status'] ?? 'Pending') ?>
                                </span>
                            </td>
                            <td class="text-muted fs-13"><?= date('d M, Y', strtotime($ord['created_at'] ?? 'now')) ?></td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-cart-x fs-36 d-block mb-2"></i>
                            No orders found yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
