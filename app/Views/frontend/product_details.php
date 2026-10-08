<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<!-- Google Fonts Inter / Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .product-view-wrapper {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #f8fafc;
        color: #0f172a;
    }
    
    /* Modern Glass Card */
    .product-details-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
    }

    /* Main Image Gallery Container */
    .main-img-box {
        position: relative;
        height: 440px;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        background: radial-gradient(circle, #ffffff 0%, #f1f5f9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 0 20px rgba(0,0,0,0.02);
    }

    .main-img-box img {
        max-height: 90%;
        max-width: 90%;
        object-fit: contain;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.06));
    }

    .main-img-box:hover img {
        transform: scale(1.12);
    }

    /* Floating Image Zoom Indicator */
    .zoom-hint-tag {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(6px);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 30px;
        pointer-events: none;
    }

    /* Thumbnail Selector Strip */
    .thumb-strip {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        overflow-x: auto;
        padding: 4px 2px;
    }

    .thumb-item {
        width: 80px;
        height: 80px;
        border-radius: 14px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        cursor: pointer;
        background: #ffffff;
        flex-shrink: 0;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 4px;
    }

    .thumb-item.active, .thumb-item:hover {
        border-color: #2563eb;
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.2);
    }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Product Titles & Tags */
    .product-main-title {
        font-size: 1.9rem;
        font-weight: 800;
        line-height: 1.25;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .badge-soft-primary {
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        border: 1px solid #bfdbfe;
    }

    .badge-soft-warning {
        background: #fffbeb;
        color: #b45309;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        border: 1px solid #fde68a;
    }

    .badge-soft-info {
        background: #f0f9ff;
        color: #0369a1;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        border: 1px solid #bae6fd;
    }

    /* Price Card Highlight */
    .price-box-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.8);
    }

    .current-price-val {
        font-size: 2.4rem;
        font-weight: 800;
        color: #2563eb;
        letter-spacing: -0.03em;
    }

    .old-price-val {
        font-size: 1.25rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* Quantity Control Pill */
    .qty-control-wrap {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 9999px;
        padding: 3px;
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: #ffffff;
        color: #0f172a;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .qty-btn:hover {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    .qty-input-field {
        width: 44px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 800;
        font-size: 1.1rem;
        color: #0f172a;
    }

    .qty-input-field:focus {
        outline: none;
    }

    /* Main CTA Buttons */
    .btn-buy-now {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.6rem 1.4rem;
        border-radius: 9999px;
        border: none;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        transition: all 0.25s ease;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        height: 44px;
    }

    .btn-buy-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(37, 99, 235, 0.45);
        color: #ffffff;
    }

    .btn-add-cart-outline {
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.6rem 1.4rem;
        border-radius: 9999px;
        border: 1.5px solid #cbd5e1;
        transition: all 0.25s ease;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        height: 44px;
    }

    .btn-add-cart-outline:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
        transform: translateY(-2px);
    }

    /* Features Grid Box */
    .features-card-grid {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
    }

    .meta-feature-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
    }

    .meta-feature-item i {
        font-size: 1.35rem;
        color: #10b981;
        background: #ecfdf5;
        padding: 6px;
        border-radius: 50%;
    }

    /* ========================================================
       PREMIUM ULTRA-MODERN PRODUCT CARD DESIGN 
       ======================================================== */
    .modern-product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.5rem;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease, border-color 0.3s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
        overflow: visible;
        z-index: 1;
    }

    .modern-product-card:hover {
        transform: translateY(-8px) scale(1.04);
        box-shadow: 0 20px 35px -10px rgba(37, 99, 235, 0.22);
        border-color: #3b82f6;
        z-index: 10;
    }

    .modern-product-card .img-wrap {
        position: relative;
        width: 100%;
        height: 160px;
        border-radius: 10px;
        overflow: hidden;
        background-color: #f8fafc;
        display: block;
        padding: 0;
    }

    .modern-product-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-product-card:hover .img-wrap img {
        transform: scale(1.12);
    }

    .product-content-modern {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        padding-top: 0.5rem;
        padding-left: 0.1rem;
        padding-right: 0.1rem;
    }

    .product-title-modern {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.35rem;
        line-height: 1.35;
        height: 2.3rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: color 0.2s ease;
    }

    .modern-product-card:hover .product-title-modern {
        color: #2563eb;
    }

    .product-footer-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 0.4rem;
        border-top: 1px dashed #f1f5f9;
    }

    .product-price-wrap {
        display: flex;
        flex-direction: column;
    }

    .price-current {
        font-size: 1.15rem;
        font-weight: 800;
        color: #2563eb;
        line-height: 1.2;
    }

    .btn-quick-cart {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.2s ease;
    }

    /* Tabs Section */
    .nav-tabs-modern {
        border-bottom: 2px solid #e2e8f0;
        gap: 2rem;
    }

    .nav-tabs-modern .nav-link {
        border: none;
        color: #64748b;
        font-weight: 700;
        font-size: 1.1rem;
        padding: 0.85rem 0.25rem;
        position: relative;
        background: transparent;
    }

    .nav-tabs-modern .nav-link.active {
        color: #2563eb;
    }

    .nav-tabs-modern .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3.5px;
        background: #2563eb;
        border-radius: 9999px;
    }
</style>

<div class="product-view-wrapper py-4">
    <div class="container">

        <!-- Modern Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 fs-13 fw-600">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-muted text-decoration-none"><i class="las la-home mr-1"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('products') ?>" class="text-muted text-decoration-none"><?= esc($product['category_name'] ?? 'Category') ?></a></li>
                <li class="breadcrumb-item active text-primary fw-700" aria-current="page"><?= esc($product['name']) ?></li>
            </ol>
        </nav>

        <!-- Product Card Container -->
        <div class="product-details-card p-4 p-md-5 mb-5">
            <div class="row gutters-15">
                
                <!-- Left: Interactive Gallery -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="main-img-box">
                        <img id="mainProductViewImg" 
                             src="<?= !empty($photos[0]) ? base_url($photos[0]) : base_url('assets/img/placeholder.jpg') ?>" 
                             alt="<?= esc($product['name']) ?>"
                             onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                        <span class="zoom-hint-tag"><i class="las la-search-plus mr-1"></i>Hover to Zoom</span>
                    </div>

                    <!-- Thumbnails -->
                    <?php if (count($photos) > 1): ?>
                        <div class="thumb-strip">
                            <?php foreach ($photos as $idx => $photo): ?>
                                <div class="thumb-item <?= $idx === 0 ? 'active' : '' ?>" onclick="switchProductImg(this, '<?= base_url($photo) ?>')">
                                    <img src="<?= base_url($photo) ?>" alt="Thumb" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Product Info & Buy Action -->
                <div class="col-lg-6">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge-soft-primary">
                            <i class="las la-folder mr-1"></i><?= esc($product['category_name'] ?? 'General') ?>
                        </span>
                        <?php if (!empty($brand_name)): ?>
                            <span class="badge badge-light border text-dark fw-600 px-3 py-1 rounded-pill">
                                Brand: <?= esc($brand_name) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($product['auction_product'])): ?>
                            <span class="badge-soft-warning">
                                <i class="las la-gavel mr-1"></i>AUCTION PRODUCT
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($product['wholesale_product'])): ?>
                            <span class="badge-soft-info">
                                <i class="las la-boxes mr-1"></i>WHOLESALE PRODUCT
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Title -->
                    <h1 class="product-main-title mb-3"><?= esc($product['name']) ?></h1>

                    <!-- Rating & Stock Status -->
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <div class="text-warning fs-14">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half-alt"></i>
                            <span class="text-dark fw-700 ml-1">4.8</span>
                            <span class="text-muted fs-12">(24 reviews)</span>
                        </div>
                        <span class="text-success fw-700 fs-14">
                            <i class="las la-check-circle mr-1"></i>In Stock
                        </span>
                    </div>

                    <!-- Price Box Card -->
                    <div class="price-box-card mb-4">
                        <?php if (!empty($product['auction_product'])): ?>
                            <span class="fs-12 fw-700 text-uppercase text-muted d-block mb-1">Starting Bid Price</span>
                            <div class="d-flex align-items-baseline gap-3">
                                <span class="current-price-val text-warning" style="color:#d97706 !important;">৳<?= number_format((float)$product['unit_price'], 2) ?></span>
                            </div>
                        <?php else: ?>
                            <span class="fs-12 fw-700 text-uppercase text-muted d-block mb-1">Price</span>
                            <div class="d-flex align-items-baseline gap-3">
                                <span class="current-price-val">৳<?= number_format($final_price, 2) ?></span>
                                <?php if ($final_price < (float)$product['unit_price']): ?>
                                    <span class="old-price-val">৳<?= number_format($product['unit_price'], 2) ?></span>
                                    <span class="badge badge-danger px-2 py-1 fs-12 fw-800 rounded-pill">
                                        <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'SAVE BIG' ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Wholesale Tier Pricing if available -->
                    <?php if (!empty($wholesale_prices)): ?>
                        <div class="mb-4">
                            <h6 class="fw-700 text-dark mb-2"><i class="las la-boxes text-info mr-1"></i> Bulk Wholesale Tier Prices</h6>
                            <div class="table-responsive">
                                <table class="table table-sm text-center wholesale-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Quantity Range</th>
                                            <th>Price Per Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wholesale_prices as $wp): ?>
                                            <tr>
                                                <td class="fw-600"><?= $wp['min_qty'] ?> - <?= $wp['max_qty'] ?> pcs</td>
                                                <td class="fw-700 text-info">৳<?= number_format($wp['price'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Bidding Box for Auction Product -->
                    <?php if (!empty($product['auction_product'])): ?>
                        <div class="p-3 mb-4 rounded-lg bg-warning-soft border border-warning" style="background: #fffbeb;">
                            <label class="fw-700 text-dark fs-14 mb-2"><i class="las la-gavel mr-1"></i> Place Your Bid Amount:</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg font-weight-bold" placeholder="Enter bid amount (Min ৳<?= number_format((float)$product['unit_price'] + 1, 2) ?>)" min="<?= (float)$product['unit_price'] + 1 ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-warning text-white fw-700 px-4" style="background:#d97706; border:none;" onclick="alert('Bid placed successfully!')">Submit Bid</button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Standard Quantity & Add to Cart Box -->
                        <div class="d-flex flex-wrap align-items-end gap-3 mb-4">
                            <div>
                                <label class="fw-700 fs-12 text-muted uppercase d-block mb-1">Quantity</label>
                                <div class="qty-control-wrap">
                                    <button class="qty-btn" onclick="updateQty(-1)">-</button>
                                    <input type="number" id="productQtyInput" class="qty-input-field" value="<?= !empty($product['min_qty']) ? $product['min_qty'] : 1 ?>" min="<?= !empty($product['min_qty']) ? $product['min_qty'] : 1 ?>">
                                    <button class="qty-btn" onclick="updateQty(1)">+</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn-buy-now px-4" onclick="alert('Proceeding to checkout...')">
                                    <i class="las la-bolt fs-18"></i> Buy Now
                                </button>
                                <button class="btn-add-cart-outline px-4" onclick="alert('Added to Cart!')">
                                    <i class="las la-shopping-bag fs-18"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Highlights & Guarantees -->
                    <div class="features-card-grid mt-4">
                        <div class="row gutters-10">
                            <div class="col-6 mb-2">
                                <div class="meta-feature-item">
                                    <i class="las la-truck"></i>
                                    <span>Fast Express Delivery</span>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="meta-feature-item">
                                    <i class="las la-shield-alt"></i>
                                    <span>100% Authentic Product</span>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="meta-feature-item">
                                    <i class="las la-redo"></i>
                                    <span>7 Days Replacement</span>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="meta-feature-item">
                                    <i class="las la-lock"></i>
                                    <span>Secure Checkout</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tabs: Description & Specifications -->
            <div class="mt-5 pt-4 border-top">
                <ul class="nav nav-tabs nav-tabs-modern mb-4" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc-pane" role="tab">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="spec-tab" data-toggle="tab" href="#spec-pane" role="tab">Specifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review-pane" role="tab">Customer Reviews (24)</a>
                    </li>
                </ul>
                <div class="tab-content" id="productTabContent">
                    <div class="tab-pane fade show active" id="desc-pane" role="tabpanel">
                        <div class="fs-15 leading-relaxed text-dark">
                            <?= !empty($product['description']) ? $product['description'] : '<p class="text-muted">No detailed description available for this product.</p>' ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="spec-pane" role="tabpanel">
                        <table class="table table-bordered w-100 max-w-600px">
                            <tbody>
                                <tr>
                                    <th class="bg-light w-30">Category</th>
                                    <td><?= esc($product['category_name'] ?? 'General') ?></td>
                                </tr>
                                <?php if (!empty($brand_name)): ?>
                                    <tr>
                                        <th class="bg-light">Brand</th>
                                        <td><?= esc($brand_name) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th class="bg-light">Product Type</th>
                                    <td>
                                        <?php 
                                            if (!empty($product['auction_product'])) echo 'Auction Product';
                                            elseif (!empty($product['wholesale_product'])) echo 'Wholesale Product';
                                            else echo 'Standard Product';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Barcode</th>
                                    <td><?= !empty($product['barcode']) ? esc($product['barcode']) : 'N/A' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="review-pane" role="tabpanel">
                        <div class="p-3 bg-light rounded text-center">
                            <h5 class="fw-700 text-dark">Customer Reviews & Ratings</h5>
                            <p class="text-muted">All reviews are verified from authentic buyers.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Products Section -->
        <?php if (!empty($related_products)): ?>
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-800 text-dark mb-0 fs-22"><i class="las la-layer-group text-primary mr-2"></i>You May Also Like</h3>
                    <a href="<?= base_url('products') ?>" class="btn-view-all">Explore More <i class="las la-arrow-right ml-1"></i></a>
                </div>
                <div class="row gutters-5">
                    <?php foreach (array_slice($related_products, 0, 5) as $rel): ?>
                        <?php 
                            $relPrice = $productModel->calculateFinalPrice($rel);
                            $relUnitPrice = (float)$rel['unit_price'];
                        ?>
                        <div class="col-lg-1-5 col-md-4 col-6 mb-3">
                            <a href="<?= base_url('product/' . $rel['slug']) ?>" class="text-reset d-block h-100 text-decoration-none">
                                <div class="modern-product-card">
                                    <div class="img-wrap">
                                        <img src="<?= !empty($rel['thumbnail_path']) ? base_url($rel['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                             alt="<?= esc($rel['name']) ?>"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                    <div class="product-content-modern">
                                        <h4 class="product-title-modern">
                                            <?= esc($rel['name']) ?>
                                        </h4>
                                        <div class="product-footer-row">
                                            <div class="product-price-wrap">
                                                <span class="price-current">৳<?= number_format($relPrice, 0) ?></span>
                                            </div>
                                            <span class="btn-quick-cart" title="View">
                                                <i class="las la-shopping-cart"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
function switchProductImg(thumbEl, imgSrc) {
    document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
    thumbEl.classList.add('active');
    document.getElementById('mainProductViewImg').src = imgSrc;
}

function updateQty(delta) {
    const qtyInput = document.getElementById('productQtyInput');
    if (!qtyInput) return;
    let min = parseInt(qtyInput.getAttribute('min')) || 1;
    let current = parseInt(qtyInput.value) || min;
    current += delta;
    if (current < min) current = min;
    qtyInput.value = current;
}
</script>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
