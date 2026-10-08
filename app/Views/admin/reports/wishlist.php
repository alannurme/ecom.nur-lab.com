<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Product Wishlist Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Most Wishlisted Products</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="50">#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Number of Wishlists</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-dark">Smart Fitness Watch Series 7</span></td>
                            <td>Electronics</td>
                            <td><span class="badge badge-inline badge-soft-primary">340 Users</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="font-weight-bold text-dark">Men Cotton Casual T-Shirt</span></td>
                            <td>Fashion</td>
                            <td><span class="badge badge-inline badge-soft-primary">215 Users</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
