<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <h3 class="fs-22 fw-800 text-dark mb-4"><i class="las la-shapes text-primary mr-1"></i> All Product Categories</h3>

        <div class="row">
            <?php foreach ($categories as $cat): ?>
                <div class="col-lg-3 col-md-4 col-6 mb-4">
                    <div class="bg-white rounded-lg border shadow-sm p-4 text-center h-100">
                        <div class="mb-3" style="height: 70px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($cat['icon_img'])): ?>
                                <img src="<?= base_url($cat['icon_img']) ?>" alt="" class="img-fluid" style="max-height: 60px;" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                            <?php else: ?>
                                <i class="las la-box text-primary fs-48"></i>
                            <?php endif; ?>
                        </div>
                        <h5 class="fw-700 text-dark fs-15 mb-2"><?= esc($cat['name']) ?></h5>
                        <a href="<?= base_url('products?keyword=' . urlencode($cat['name'])) ?>" class="btn btn-soft-primary btn-sm btn-block fw-700 mt-3">
                            Explore Category <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
