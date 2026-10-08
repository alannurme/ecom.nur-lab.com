<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Wallet Recharge History Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Customer Wallet Recharge Log</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="50">#</th>
                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Approval Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-dark">Paul K. Vance</span></td>
                            <td class="fw-700 text-success">$100.00</td>
                            <td><span class="badge badge-inline badge-soft-info">bKash Manual</span></td>
                            <td><span class="badge badge-inline badge-soft-success">Approved</span></td>
                            <td>2026-10-05 14:20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
