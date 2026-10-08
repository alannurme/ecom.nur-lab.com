<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Commission History Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Admin Commission Earning History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="50">#</th>
                            <th>Order Code</th>
                            <th>Seller</th>
                            <th>Admin Commission Amount</th>
                            <th>Seller Earning</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-primary">#ORD-984321</span></td>
                            <td>Fashion Digital Hub</td>
                            <td class="fw-700 text-success">$15.00</td>
                            <td class="fw-600">$135.00</td>
                            <td>2026-10-06 11:30</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
