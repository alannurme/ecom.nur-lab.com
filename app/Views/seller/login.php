<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container py-md-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                    <div class="row no-gutters">
                        <!-- Left Side Image & Info -->
                        <div class="col-md-6 bg-dark text-white p-4 p-md-5 d-flex flex-column justify-content-between position-relative" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                            <div>
                                <div class="mb-4">
                                    <img src="<?= base_url(!empty($system_logo) ? $system_logo : 'assets/img/logo.png') ?>" alt="Logo" class="h-40px max-w-150px bg-white rounded p-1" onerror="this.src='<?= base_url('assets/img/logo.png') ?>';">
                                </div>
                                <h3 class="fw-800 text-white mb-2">Grow your business with <?= esc($site_name) ?></h3>
                                <p class="text-white-50 fs-14">Join thousands of sellers. Manage products, orders, inventory, and track earnings with our seller portal.</p>
                            </div>

                            <div class="pt-4 border-top border-white-10">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="las la-check-circle text-success fs-18 mr-2"></i>
                                    <span class="fs-13">Fast payment settlements & low commission</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="las la-check-circle text-success fs-18 mr-2"></i>
                                    <span class="fs-13">Reach millions of active online buyers</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="las la-check-circle text-success fs-18 mr-2"></i>
                                    <span class="fs-13">Full control over inventory & analytics</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Login Form -->
                        <div class="col-md-6 p-4 p-md-5">
                            <div class="mb-4">
                                <h4 class="fw-800 text-dark mb-1">Seller Login</h4>
                                <p class="text-muted fs-13 mb-0">Enter your credentials to access your store panel.</p>
                            </div>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger border-0 rounded-2 fs-13 mb-3">
                                    <i class="las la-exclamation-circle mr-1"></i> <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <!-- Demo Credentials Box -->
                            <div class="bg-soft-primary p-3 rounded-2 border border-primary-20 mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fs-12 fw-700 text-primary uppercase"><i class="las la-key mr-1"></i> Demo Seller Account:</span>
                                    <button type="button" class="btn btn-xs btn-primary fw-600 rounded" onclick="fillDemoSeller()">
                                        Copy Demo Login
                                    </button>
                                </div>
                                <div class="fs-12 text-secondary">
                                    <div><strong>Email:</strong> <span id="demoSellerEmail">seller@example.com</span></div>
                                    <div><strong>Password:</strong> <span>123456</span></div>
                                </div>
                            </div>

                            <form action="<?= base_url('seller/login-process') ?>" method="POST" id="sellerLoginForm">
                                <?= csrf_field() ?>
                                
                                <div class="form-group mb-3">
                                    <label class="fw-700 fs-13 text-dark">Email Address / Phone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="las la-envelope text-muted"></i></span>
                                        </div>
                                        <input type="email" name="email" id="sellerEmail" class="form-control border-left-0" placeholder="seller@example.com" value="seller@example.com" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="fw-700 fs-13 text-dark mb-0">Password</label>
                                        <a href="javascript:void(0);" class="fs-12 text-primary">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="las la-lock text-muted"></i></span>
                                        </div>
                                        <input type="password" name="password" id="sellerPassword" class="form-control border-left-0" placeholder="••••••••" value="123456" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="aiz-checkbox mb-0 fs-13">
                                        <input type="checkbox" name="remember" checked>
                                        <span class="aiz-square-check"></span>
                                        <span class="ml-2 text-muted">Remember me on this device</span>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block btn-lg fw-700 py-2.5 rounded-2 shadow-sm">
                                    <i class="las la-sign-in-alt mr-1"></i> Login to Store Panel
                                </button>
                            </form>

                            <div class="text-center mt-4 pt-3 border-top fs-13">
                                <span class="text-muted">Don't have a seller account?</span>
                                <a href="<?= base_url('seller/register') ?>" class="text-primary fw-700 ml-1">Apply as Seller</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function fillDemoSeller() {
    document.getElementById('sellerEmail').value = 'seller@example.com';
    document.getElementById('sellerPassword').value = '123456';
}
</script>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
