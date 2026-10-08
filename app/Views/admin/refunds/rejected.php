<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Rejected Refunds</h1>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Rejected Refund List</h5>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search Request...">
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Code</th>
                        <th>Product</th>
                        <th>Rejection Reason</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No rejected refunds found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
