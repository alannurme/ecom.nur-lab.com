<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="bg-white rounded-lg border shadow-sm p-4 p-md-5">
                    <h4 class="fw-800 text-dark text-center mb-1">Create an Account</h4>
                    <p class="text-secondary fs-13 text-center mb-4">Join us today to get special offers & fast checkout.</p>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger border-0 fs-13 mb-3">
                            <i class="las la-exclamation-circle mr-1"></i> <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/register-process') ?>" method="POST">
                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Email Address *</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="fw-700 fs-13 text-dark">Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Create password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg fw-700 py-2">
                            Create Account <i class="las la-user-plus ml-1"></i>
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top fs-13">
                        <span class="text-secondary">Already have an account?</span>
                        <a href="<?= base_url('user/login') ?>" class="text-primary fw-700 ml-1">Login Here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
