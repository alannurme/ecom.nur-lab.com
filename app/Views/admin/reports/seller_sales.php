<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Seller Based Selling Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Vendor Sales Report</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row gutters-10 align-items-center">
                    <div class="col-md-4">
                        <label class="col-from-label fs-14 fw-500 mb-0">Sort by Verification Status</label>
                        <select class="form-control aiz-selectpicker" name="verification_status">
                            <option value="">Choose Status</option>
                            <option value="1">Approved Sellers</option>
                            <option value="0">Non Approved Sellers</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button class="btn btn-primary font-weight-bold px-4" type="submit">Filter Report</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th>Seller Name</th>
                            <th>Shop Name</th>
                            <th>Number of Product Sales</th>
                            <th>Total Order Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rahim Chowdhury</td>
                            <td><span class="font-weight-bold text-dark">Fashion Digital Hub</span></td>
                            <td><span class="badge badge-inline badge-soft-primary">210 Sales</span></td>
                            <td class="fw-700 text-success">$8,920.00</td>
                        </tr>
                        <tr>
                            <td>Karim Uddin</td>
                            <td><span class="font-weight-bold text-dark">Electro World Store</span></td>
                            <td><span class="badge badge-inline badge-soft-primary">155 Sales</span></td>
                            <td class="fw-700 text-success">$14,350.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
