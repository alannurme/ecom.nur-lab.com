<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<main class="py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white border rounded-pill px-4 py-2 fs-13">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-primary fw-600">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-primary fw-600"><?= esc($product['category_name'] ?? 'Category') ?></a></li>
                <li class="breadcrumb-item active text-dark fw-600" aria-current="page"><?= esc($product['name']) ?></li>
            </ol>
        </nav>

        <!-- Product View Card -->
        <div class="bg-white rounded-lg border p-4 shadow-sm mb-5">
            <div class="row">
                <!-- Product Image Gallery -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="border rounded p-3 text-center bg-light" style="height: 380px; display: flex; align-items: center; justify-content: center;">
                        <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>" 
                             alt="<?= esc($product['name']) ?>" 
                             class="img-fluid mh-100 mw-100"
                             onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                    </div>
                </div>

                <!-- Product Info & Buying Actions -->
                <div class="col-lg-7">
                    <h2 class="fs-22 fw-800 text-dark mb-2"><?= esc($product['name']) ?></h2>
                    
                    <div class="d-flex align-items-center mb-3 fs-13">
                        <span class="badge badge-light border mr-3 px-3 py-1">Category: <?= esc($product['category_name'] ?? 'General') ?></span>
                        <span class="text-success fw-600"><i class="las la-check-circle mr-1"></i> In Stock</span>
                    </div>

                    <hr>

                    <!-- Price Box -->
                    <div class="bg-light p-3 rounded mb-4 d-flex align-items-baseline">
                        <h3 class="fs-28 fw-800 text-primary mb-0 mr-3">৳<?= number_format($final_price, 2) ?></h3>
                        <?php if ($final_price < (float)$product['unit_price']): ?>
                            <del class="fs-16 text-muted fw-400 mr-3">৳<?= number_format($product['unit_price'], 2) ?></del>
                            <span class="badge badge-danger px-2 py-1 fs-12 fw-700">
                                <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'DISCOUNT' ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="mr-4">
                            <label class="fw-700 fs-13 text-dark d-block">Quantity:</label>
                            <input type="number" class="form-control text-center font-weight-bold" value="1" min="1" style="width: 100px; height: 42px;">
                        </div>
                        <div class="flex-grow-1 pt-4">
                            <button class="btn btn-primary btn-lg btn-block fw-700">
                                <i class="las la-shopping-cart mr-2"></i> Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="border-top pt-3">
                        <h6 class="fw-700 text-dark fs-14 mb-2">Description</h6>
                        <div class="text-muted fs-13 leading-normal">
                            <?= !empty($product['description']) ? $product['description'] : 'No description available for this product.' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($related_products)): ?>
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h4 class="fw-800 text-dark mb-0 fs-20"><i class="las la-tags text-primary mr-1"></i> Related Products</h4>
                </div>
                <div class="row">
                    <?php foreach ($related_products as $rel): ?>
                        <?php 
                            $relPrice = $productModel->calculateFinalPrice($rel);
                            $relUnitPrice = (float)$rel['unit_price'];
                        ?>
                        <div class="col-lg-3 col-md-4 col-6 mb-4">
                            <div class="product-box h-100 p-2 d-flex flex-column justify-content-between">
                                <div class="position-relative overflow-hidden text-center" style="height: 180px;">
                                    <a href="<?= base_url('product/' . $rel['slug']) ?>">
                                        <img class="img-fit h-100 mw-100 has-transition"
                                             src="<?= !empty($rel['thumbnail_path']) ? base_url($rel['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                             alt="<?= esc($rel['name']) ?>"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </a>
                                </div>
                                <div class="p-2 text-center">
                                    <h4 class="fs-14 fw-700 text-dark text-truncate-2 mb-2" style="height: 40px; overflow: hidden;">
                                        <a href="<?= base_url('product/' . $rel['slug']) ?>" class="text-dark text-decoration-none">
                                            <?= esc($rel['name']) ?>
                                        </a>
                                    </h4>
                                    <div class="fs-14 fw-700 text-primary">
                                        <span>৳<?= number_format($relPrice, 2) ?></span>
                                    </div>
                                    <button class="btn btn-soft-primary btn-sm btn-block mt-2 fw-700">
                                        <i class="las la-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
