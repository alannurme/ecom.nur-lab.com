<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="bg-white rounded-lg border shadow-sm p-4 text-center">
                    <div class="size-60px rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fs-24 fw-700 mb-2">
                        <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <h5 class="fw-800 text-dark mb-0"><?= esc($user['name']) ?></h5>
                    <small class="text-muted d-block mb-3"><?= esc($user['email']) ?></small>
                    <a href="<?= base_url('user/logout') ?>" class="btn btn-soft-danger btn-sm btn-block fw-700">
                        <i class="las la-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="bg-white rounded-lg border shadow-sm p-4 mb-4">
                    <h5 class="fw-800 text-dark border-bottom pb-3 mb-3">Customer Dashboard</h5>
                    <p class="text-secondary fs-14">Welcome to your personal account hub. Here you can check your orders, update profile details and track delivery progress.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
