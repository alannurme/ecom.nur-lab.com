<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-5">
    <div class="container text-center">
        <div class="bg-white rounded-lg border shadow-sm p-5 max-w-600px mx-auto">
            <div class="size-70px rounded-circle bg-soft-success text-success d-inline-flex align-items-center justify-content-center fs-36 mb-3">
                <i class="las la-check-circle"></i>
            </div>
            <h2 class="fw-800 text-dark mb-2">Thank You For Your Order!</h2>
            <p class="text-secondary fs-15 mb-4">Your order has been placed successfully and is being processed.</p>
            
            <div class="bg-light p-3 rounded mb-4 d-inline-block px-4">
                <span class="text-muted fs-13 d-block">Order Reference Code:</span>
                <strong class="fs-18 text-primary fw-800">#<?= esc($order_code) ?></strong>
            </div>

            <div>
                <a href="<?= base_url() ?>" class="btn btn-primary btn-lg fw-700 px-5">Continue Shopping</a>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
