<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container py-md-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="bg-white rounded-lg shadow-sm border p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-800 text-dark mb-1">Apply to Become a Seller</h4>
                        <p class="text-muted fs-13">Fill out your details to start selling on <?= esc($site_name) ?></p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger border-0 rounded-2 fs-13 mb-3">
                            <i class="las la-exclamation-circle mr-1"></i> <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('seller/register-process') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Shop / Store Name</label>
                            <input type="text" name="shop_name" class="form-control" placeholder="My Awesome Electronics Shop" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-700 fs-13 text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="seller@example.com" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="fw-700 fs-13 text-dark">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg fw-700 py-2.5 rounded-2 shadow-sm">
                            <i class="las la-store mr-1"></i> Register Shop Now
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top fs-13">
                        <span class="text-muted">Already have a seller account?</span>
                        <a href="<?= base_url('seller/login') ?>" class="text-primary fw-700 ml-1">Login Here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
