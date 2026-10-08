<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Seller Payouts</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 h6 font-weight-bold">Payout Payments History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th>#</th>
                            <th>Date</th>
                            <th>Seller</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Txn ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2026-10-01 14:22</td>
                            <td>Fashion Digital Store</td>
                            <td>$500.00</td>
                            <td><span class="badge badge-inline badge-soft-info">Bank Transfer</span></td>
                            <td>TXN-9843210</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
