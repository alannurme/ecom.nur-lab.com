<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Product Wise Stock Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Inventory & Stock Status</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row gutters-10 align-items-center">
                    <div class="col-md-4">
                        <label class="col-from-label fs-14 fw-500 mb-0">Sort by Category</label>
                        <select class="form-control aiz-selectpicker" name="category_id">
                            <option value="">Choose Category</option>
                            <option value="1">Fashion & Clothing</option>
                            <option value="2">Electronics</option>
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
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Current Stock Qty</th>
                            <th>Stock Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-dark">Men Cotton Shirt - XL</span></td>
                            <td>Fashion</td>
                            <td class="fw-700">120 Pcs</td>
                            <td><span class="badge badge-inline badge-soft-success">In Stock</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="font-weight-bold text-dark">Wireless Headphones Black</span></td>
                            <td>Electronics</td>
                            <td class="fw-700 text-danger">4 Pcs</td>
                            <td><span class="badge badge-inline badge-soft-danger">Low Stock</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
