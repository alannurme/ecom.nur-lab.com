<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Classified Packages</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="#" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Add New Package
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Amount</th>
                            <th>Product Upload Limit</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Basic Listing Package</td>
                            <td>$10.00</td>
                            <td>5 Products</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm"><i class="las la-pen"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
