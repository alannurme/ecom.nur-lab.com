<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Add New Delivery Boy</h1>
        </div>
        <div class="col text-right">
            <a class="btn btn-xs btn-soft-warning" href="<?= base_url('admin/delivery-boys') ?>">
                All Delivery Boys
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Delivery Boy Information</h5>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Name" name="name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="email" placeholder="Email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label">Phone <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Phone" name="phone" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label">Password <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="Password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label">Address</label>
                    <div class="col-sm-9">
                        <textarea name="address" rows="3" class="form-control" placeholder="Address"></textarea>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">Save Delivery Boy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
