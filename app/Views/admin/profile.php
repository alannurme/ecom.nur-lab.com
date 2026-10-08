<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Manage Profile</h1>
    <span class="fs-13 text-muted">Update your admin account details, email, and password</span>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="px-3 px-md-2rem mb-3">
        <div class="alert alert-success border-0 shadow-sm rounded-2">
            <i class="las la-check-circle mr-2 fs-18"></i> <?= session()->getFlashdata('success') ?>
        </div>
    </div>
<?php endif; ?>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Basic Info Card -->
            <div class="card shadow-sm border-0 rounded-2 mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/profile/update') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($adminUser['id'] ?? '') ?>">
                        
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Your Name</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" value="<?= esc($adminUser['name'] ?? 'Admin User') ?>" required>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Email Address</label>
                            <div class="col-md-9">
                                <input type="email" name="email" class="form-control" value="<?= esc($adminUser['email'] ?? 'admin@nur-lab.com') ?>" required>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Phone Number</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control" value="<?= esc($adminUser['phone'] ?? '') ?>" placeholder="+880 1700-000000">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">New Password</label>
                            <div class="col-md-9">
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                            </div>
                        </div>

                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Confirm Password</label>
                            <div class="col-md-9">
                                <input type="password" name="password_confirm" class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary rounded-2 px-4 font-weight-bold">
                                <i class="las la-save mr-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
