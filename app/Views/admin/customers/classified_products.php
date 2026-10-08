<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Classified Products</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 h6 font-weight-bold">Customer Classified Products List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th>#</th>
                            <th>Name</th>
                            <th>Customer</th>
                            <th>Price</th>
                            <th>Published</th>
                            <th>Status</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Used iPhone 12 Pro Max</td>
                            <td>Rahim Ahmed</td>
                            <td>$650.00</td>
                            <td><span class="badge badge-inline badge-soft-success">Published</span></td>
                            <td><span class="badge badge-inline badge-soft-primary">Approved</span></td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm"><i class="las la-eye"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
