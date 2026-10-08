<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <h3 class="fs-22 fw-800 text-dark mb-4"><i class="las la-copyright text-primary mr-1"></i> All Popular Brands</h3>

        <div class="row">
            <?php if (!empty($brands)): ?>
                <?php foreach ($brands as $brand): ?>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="bg-white rounded-lg border shadow-sm p-3 text-center h-100">
                            <div class="mb-2" style="height: 60px; display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($brand['logo_path'])): ?>
                                    <img src="<?= base_url($brand['logo_path']) ?>" alt="" class="img-fluid" style="max-height: 50px;" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                <?php else: ?>
                                    <i class="las la-award text-primary fs-36"></i>
                                <?php endif; ?>
                            </div>
                            <h6 class="fw-700 text-dark fs-13 mb-0"><?= esc($brand['name']) ?></h6>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No brands registered yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
