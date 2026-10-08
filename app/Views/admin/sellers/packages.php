<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Seller Packages</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addPackageModal" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Add New Package
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Grid of Seller Packages Cards -->
    <div class="row gutters-15 mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border-0 rounded-2 text-center h-100 p-3">
                <div class="card-body">
                    <span class="avatar avatar-lg mx-auto mb-3 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                        <i class="las la-gem fs-32"></i>
                    </span>
                    <h5 class="fw-700 text-dark mb-2">Starter Package</h5>
                    <div class="h3 text-primary font-weight-bold mb-3">$19.00</div>
                    <ul class="list-unstyled text-muted fs-14 mb-4">
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Product Upload Limit: <strong>50 Items</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Validity Duration: <strong>30 Days</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Featured Product: <strong>5 Items</strong></li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm px-3 mr-2 font-weight-bold"><i class="las la-pen mr-1"></i> Edit</a>
                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm px-3 font-weight-bold"><i class="las la-trash mr-1"></i> Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border border-primary rounded-2 text-center h-100 p-3" style="border-width: 2px !important;">
                <div class="card-body">
                    <span class="badge badge-primary px-3 py-1 mb-2">POPULAR</span>
                    <span class="avatar avatar-lg mx-auto mb-3 bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                        <i class="las la-crown fs-32"></i>
                    </span>
                    <h5 class="fw-700 text-dark mb-2">Gold Business</h5>
                    <div class="h3 text-primary font-weight-bold mb-3">$99.00</div>
                    <ul class="list-unstyled text-muted fs-14 mb-4">
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Product Upload Limit: <strong>500 Items</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Validity Duration: <strong>365 Days</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Featured Product: <strong>50 Items</strong></li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm px-3 mr-2 font-weight-bold"><i class="las la-pen mr-1"></i> Edit</a>
                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm px-3 font-weight-bold"><i class="las la-trash mr-1"></i> Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border-0 rounded-2 text-center h-100 p-3">
                <div class="card-body">
                    <span class="avatar avatar-lg mx-auto mb-3 bg-soft-warning text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                        <i class="las la-rocket fs-32"></i>
                    </span>
                    <h5 class="fw-700 text-dark mb-2">Unlimited VIP</h5>
                    <div class="h3 text-primary font-weight-bold mb-3">$299.00</div>
                    <ul class="list-unstyled text-muted fs-14 mb-4">
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Product Upload Limit: <strong>Unlimited</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Validity Duration: <strong>365 Days</strong></li>
                        <li class="py-1"><i class="las la-check-circle text-success mr-1"></i> Featured Product: <strong>Unlimited</strong></li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-soft-primary btn-sm px-3 mr-2 font-weight-bold"><i class="las la-pen mr-1"></i> Edit</a>
                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm px-3 font-weight-bold"><i class="las la-trash mr-1"></i> Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Package -->
<div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Create New Seller Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Package Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Package Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Amount ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" name="amount" placeholder="0.00" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Product Upload Limit <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="1" class="form-control" name="product_upload_limit" placeholder="e.g. 100" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Duration (Days) <span class="text-danger">*</span></label>
                        <input type="number" min="1" step="1" class="form-control" name="duration" placeholder="e.g. 30" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save Package</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
