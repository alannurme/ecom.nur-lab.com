<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">In House Product Sale Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">In-house Sales Directory</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row gutters-10 align-items-center">
                    <div class="col-md-4">
                        <label class="col-from-label fs-14 fw-500 mb-0">Sort by Category</label>
                        <select class="form-control aiz-selectpicker" name="category_id">
                            <option value="">Choose Category</option>
                            <option value="1">Fashion & Clothing</option>
                            <option value="2">Electronics & Accessories</option>
                            <option value="3">Groceries & Food</option>
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
                            <th width="50">#</th>
                            <th>Product Name</th>
                            <th>Num of Sales</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-dark">Men Cotton Casual T-Shirt</span></td>
                            <td><span class="badge badge-inline badge-soft-info">142 Sales</span></td>
                            <td class="fw-700 text-success">$2,130.00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="font-weight-bold text-dark">Wireless Bluetooth Headphones</span></td>
                            <td><span class="badge badge-inline badge-soft-info">98 Sales</span></td>
                            <td class="fw-700 text-success">$4,410.00</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="font-weight-bold text-dark">Smart Fitness Watch Series 7</span></td>
                            <td><span class="badge badge-inline badge-soft-info">76 Sales</span></td>
                            <td class="fw-700 text-success">$6,840.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
