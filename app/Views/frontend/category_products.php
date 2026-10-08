<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="fs-20 fw-800 text-dark mb-0">
                <?= !empty($keyword) ? 'Search Results for "' . esc($keyword) . '"' : 'All Products Catalog' ?>
            </h3>
            <span class="text-muted fs-13"><?= count($products) ?> Products Available</span>
        </div>

        <div class="row">
            <!-- Products Grid -->
            <div class="col-12">
                <div class="row gutters-16">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?php 
                                $finalPrice = $productModel->calculateFinalPrice($product);
                                $unitPrice = (float)$product['unit_price'];
                            ?>
                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                <div class="product-box h-100 p-2 d-flex flex-column justify-content-between">
                                    <div class="position-relative overflow-hidden text-center" style="height: 180px;">
                                        <?php if ($product['discount'] > 0): ?>
                                            <span class="badge badge-danger position-absolute left-0 top-0 fs-11 px-2 py-1 z-2">
                                                <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                            </span>
                                        <?php endif; ?>
                                        <a href="<?= base_url('product/' . $product['slug']) ?>">
                                            <img class="img-fit h-100 mw-100 has-transition"
                                                 src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                                 alt="<?= esc($product['name']) ?>"
                                                 onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                        </a>
                                    </div>
                                    <div class="p-2 text-center">
                                        <h4 class="fs-14 fw-700 text-dark text-truncate-2 mb-2" style="height: 40px; overflow: hidden;">
                                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-dark text-decoration-none">
                                                <?= esc($product['name']) ?>
                                            </a>
                                        </h4>
                                        <div class="fs-14 fw-700 text-primary">
                                            <span>৳<?= number_format($finalPrice, 2) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <del class="fs-12 text-muted fw-400 ml-2">৳<?= number_format($unitPrice, 2) ?></del>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn btn-soft-primary btn-sm btn-block mt-2 fw-700">
                                            <i class="las la-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="las la-search-location text-muted fs-48"></i>
                            <p class="text-muted mt-2">No products matched your search or category criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
