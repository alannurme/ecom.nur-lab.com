<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<!-- Google Fonts Inter / Plus Jakarta Sans for ultra-clean look -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Modern Global Theme Scope for Homepage Body */
    .home-modern-wrapper {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: #f1f5f9;
        color: #0f172a;
    }

    @media (min-width: 992px) {
        .col-lg-1-5 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-1-5 {
            flex: 0 0 20%;
            max-width: 20%;
        }
        .col-xl-1-7 {
            flex: 0 0 14.2857%;
            max-width: 14.2857%;
        }
    }

    /* Custom Modern Section Headers */
    .section-title-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-title-main {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .section-title-main i {
        font-size: 1.5rem;
    }

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.875rem;
        font-weight: 700;
        color: #2563eb;
        background: #ffffff;
        padding: 0.5rem 1.1rem;
        border-radius: 9999px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
    }

    .btn-view-all:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        transform: translateX(2px);
    }

    /* Hero Slider Container */
    .hero-slider-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.12);
    }
    
    .hero-banner-img {
        border-radius: 20px;
        object-fit: cover;
    }

    /* Hot Categories Chips */
    .hot-category-chip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.75rem 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        text-decoration: none !important;
        height: 72px;
    }

    .hot-category-chip:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(239, 68, 68, 0.15);
        border-color: #fca5a5;
    }

    .hot-cat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #fef2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .hot-cat-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hot-cat-info {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .hot-cat-name {
        font-size: 0.875rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .hot-cat-badge {
        font-size: 0.725rem;
        font-weight: 700;
        color: #ef4444;
        display: flex;
        align-items: center;
        gap: 0.15rem;
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
        box-shadow: 0 20px 35px -10px rgba(239, 68, 68, 0.2);
        border-color: #f87171;
        z-index: 10;
    }

    /* Image Wrapper with Soft Backdrop */
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

    /* Floating Quick View / Action Overlay on Hover - Hidden */
    .product-action-overlay {
        display: none !important;
    }

    .action-btn-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        transition: all 0.25s ease;
        text-decoration: none !important;
    }

    .action-btn-circle:hover {
        background: #e62e04;
        color: #ffffff;
        transform: scale(1.15);
    }

    /* Badges */
    .discount-badge-modern {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.3rem 0.65rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        z-index: 4;
        letter-spacing: 0.5px;
    }

    .hot-badge-modern {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        color: #f59e0b;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        z-index: 4;
    }

    /* Content Area */
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
        color: #e62e04;
    }

    /* Price Section */
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
        font-size: 1.2rem;
        font-weight: 800;
        color: #e62e04;
        line-height: 1.2;
    }

    .price-old {
        font-size: 0.825rem;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 600;
        margin-top: 0.15rem;
    }

    /* Quick Add Cart Button */
    .btn-quick-cart {
        width: 40px !important;
        height: 40px !important;
        border-radius: 12px !important;
        background: #fee2e2 !important;
        color: #dc2626 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.25rem !important;
        border: 1px solid #fca5a5 !important;
        transition: all 0.25s ease !important;
        text-decoration: none !important;
        flex-shrink: 0 !important;
        cursor: pointer !important;
        padding: 0 !important;
    }

    .btn-quick-cart i,
    .btn-quick-cart svg {
        color: #dc2626 !important;
        transition: color 0.25s ease !important;
    }

    .modern-product-card:hover .btn-quick-cart,
    .btn-quick-cart:hover {
        background: #dc2626 !important;
        color: #ffffff !important;
        border-color: #dc2626 !important;
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4) !important;
    }

    .modern-product-card:hover .btn-quick-cart i,
    .modern-product-card:hover .btn-quick-cart svg,
    .btn-quick-cart:hover i,
    .btn-quick-cart:hover svg {
        color: #ffffff !important;
    }

    /* Featured Categories Grid */
    .category-card-modern {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        height: 220px;
        display: block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.35s ease;
    }

    .category-card-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .category-card-modern:hover img {
        transform: scale(1.1);
    }

    .category-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.85) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.25rem;
        color: #ffffff;
        transition: background 0.3s ease;
    }

    .category-card-modern:hover .category-card-overlay {
        background: linear-gradient(180deg, rgba(37, 99, 235, 0.2) 0%, rgba(15, 23, 42, 0.9) 100%);
    }

    .category-title-text {
        font-size: 1.1rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .category-title-text i {
        font-size: 1.2rem;
        transform: translateX(-4px);
        transition: transform 0.3s ease;
    }

    .category-card-modern:hover .category-title-text i {
        transform: translateX(4px);
    }

    /* Coupon Banner */
    .coupon-section-wrapper {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #1e293b 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        padding: 2.5rem 2.5rem;
        box-shadow: 0 15px 35px -10px rgba(30, 27, 75, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .coupon-section-wrapper::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -5%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .promo-tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fbbf24;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        text-transform: uppercase;
    }
        position: absolute;
        top: -50%;
        right: -10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Top Sellers Card */
    .seller-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem 1rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .seller-card-modern:hover {
        transform: translateY(-5px);
        border-color: #3b82f6;
        box-shadow: 0 12px 24px -6px rgba(0,0,0,0.06);
    }

    .seller-logo-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        padding: 4px;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        margin-bottom: 0.85rem;
        overflow: hidden;
    }

    .seller-logo-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Brands Showcase */
    .brand-chip-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 110px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .brand-chip-card:hover {
        transform: translateY(-4px);
        border-color: #2563eb;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.08);
    }

    .brand-chip-card img {
        max-height: 48px;
        max-width: 80%;
        object-fit: contain;
        filter: grayscale(20%);
        transition: filter 0.3s ease;
    }

    .brand-chip-card:hover img {
        filter: grayscale(0%);
    }

    .brand-name-text {
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        margin-top: 0.5rem;
    }
</style>

<div class="home-modern-wrapper py-4">
    <div class="container">

        <!-- 1. Hero Sliders Section -->
        <?php if (!empty($sliders)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="hero-slider-card">
                        <div class="aiz-carousel dots-inside-bottom" data-autoplay="true" data-infinite="true" data-arrows="true">
                            <?php foreach ($sliders as $slider): ?>
                                <div class="carousel-box">
                                    <a href="<?= base_url('products') ?>" class="d-block">
                                        <div class="d-block mw-100 img-fit overflow-hidden h-200px h-md-360px h-lg-480px h-xl-520px">
                                            <img class="img-fit h-100 w-100 hero-banner-img"
                                                 src="<?= base_url($slider['file_name']) ?>"
                                                 alt="<?= esc($site_name) ?> Banner"
                                                 onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-rect.jpg') ?>';">
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- 2. Hot Categories Section -->
        <?php if (!empty($hot_categories)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-danger bg-danger-soft d-inline-flex align-items-center justify-content-center" style="background:#fef2f2; width:36px; height:36px;">
                            <i class="las la-fire fs-20" style="color:#ef4444;"></i>
                        </span>
                        <span>Hot Categories</span>
                    </div>
                </div>

                <div class="aiz-carousel arrow-inactive-none arrow-x-0" 
                     data-items="6" data-xxl-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                     data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
                    <?php foreach ($hot_categories as $cat): ?>
                        <div class="carousel-box px-2">
                            <a href="<?= base_url('category/' . esc($cat['slug'])) ?>" class="hot-category-chip">
                                <div class="hot-cat-icon">
                                    <img src="<?= !empty($cat['icon_img']) ? base_url($cat['icon_img']) : (!empty($cat['banner_img']) ? base_url($cat['banner_img']) : base_url('assets/img/placeholder.jpg')) ?>"
                                         alt="<?= esc($cat['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                </div>
                                <div class="hot-cat-info">
                                    <h6 class="hot-cat-name"><?= esc($cat['name']) ?></h6>
                                    <span class="hot-cat-badge">Trending <i class="las la-angle-right"></i></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 3. Flash Sale Section -->
        <?php if (!empty($todays_deals)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                            <i class="las la-bolt fs-20"></i>
                        </span>
                        <span>Flash Deals & Discounts</span>
                    </div>
                    <a href="<?= base_url('products') ?>" class="btn-view-all">
                        View All <i class="las la-arrow-right"></i>
                    </a>
                </div>

                <div class="row gutters-5">
                    <?php foreach (array_slice($todays_deals, 0, 6) as $product): ?>
                        <?php 
                            $finalPrice = $productModel->calculateFinalPrice($product);
                            $unitPrice = (float)$product['unit_price'];
                        ?>
                        <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                            <div class="modern-product-card">
                                <?php if ($product['discount'] > 0): ?>
                                    <div class="discount-badge-modern">
                                        <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'SALE' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="hot-badge-modern">
                                    <i class="las la-fire"></i>
                                </div>
                                <div class="img-wrap">
                                    <a href="<?= base_url('product/' . esc($product['slug'])) ?>">
                                        <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                             alt="<?= esc($product['name']) ?>"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </a>
                                </div>
                                <div class="product-content-modern">
                                    <h4 class="product-title-modern">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </h4>
                                    <div class="product-footer-row">
                                        <div class="product-price-wrap">
                                            <span class="price-current">৳<?= number_format($finalPrice, 0) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <span class="price-old">৳<?= number_format($unitPrice, 0) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn-quick-cart" title="Add to Cart" style="cursor: pointer;">
                                            <i class="las la-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Minimalist Clean Auction Products Section -->
        <?php if (!empty($auction_products)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center" style="width:36px; height:36px; background:#d97706 !important;">
                            <i class="las la-gavel fs-20"></i>
                        </span>
                        <span>Live Auction Products</span>
                    </div>
                    <a href="<?= base_url('auction') ?>" class="btn-view-all">
                        View All <i class="las la-arrow-right"></i>
                    </a>
                </div>

                <div class="row gutters-5">
                    <?php foreach (array_slice($auction_products, 0, 5) as $product): ?>
                        <div class="col-lg-1-5 col-md-4 col-6 mb-2">
                            <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset d-block h-100 text-decoration-none">
                                <div class="modern-product-card">
                                    <div class="discount-badge-modern" style="background:#d97706;">
                                        <i class="las la-gavel"></i> AUCTION
                                    </div>
                                    <div class="img-wrap">
                                        <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                             alt="<?= esc($product['name']) ?>"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                    <div class="product-content-modern">
                                        <h4 class="product-title-modern">
                                            <?= esc($product['name']) ?>
                                        </h4>
                                        <div class="product-footer-row">
                                            <div class="product-price-wrap">
                                                <span class="fs-10 text-muted d-block">Starting Bid</span>
                                                <span class="price-current" style="color:#d97706;">৳<?= number_format((float)$product['unit_price'], 0) ?></span>
                                            </div>
                                            <span class="btn-quick-cart" style="background:#d97706; color:#fff;" title="Place Bid">
                                                <i class="las la-gavel"></i>
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

        <!-- Minimalist Clean Wholesale Products Section -->
        <?php if (!empty($wholesale_products)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center" style="width:36px; height:36px; background:#0284c7 !important;">
                            <i class="las la-boxes fs-20"></i>
                        </span>
                        <span>Wholesale Products</span>
                    </div>
                    <a href="<?= base_url('wholesale') ?>" class="btn-view-all">
                        View All <i class="las la-arrow-right"></i>
                    </a>
                </div>

                <div class="row gutters-5">
                    <?php foreach (array_slice($wholesale_products, 0, 5) as $product): ?>
                        <div class="col-lg-1-5 col-md-4 col-6 mb-2">
                            <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset d-block h-100 text-decoration-none">
                                <div class="modern-product-card">
                                    <div class="discount-badge-modern" style="background:#0284c7;">
                                        <i class="las la-boxes"></i> BULK
                                    </div>
                                    <div class="img-wrap">
                                        <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                             alt="<?= esc($product['name']) ?>"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                    <div class="product-content-modern">
                                        <h4 class="product-title-modern">
                                            <?= esc($product['name']) ?>
                                        </h4>
                                        <div class="product-footer-row">
                                            <div class="product-price-wrap">
                                                <span class="fs-10 text-muted d-block">Min Qty: <?= $product['min_qty'] ?? 1 ?></span>
                                                <span class="price-current" style="color:#0284c7;">৳<?= number_format((float)$product['unit_price'], 0) ?></span>
                                            </div>
                                            <span class="btn-quick-cart" style="background:#0284c7; color:#fff;" title="Order Wholesale">
                                                <i class="las la-shopping-bag"></i>
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

        <!-- 4. Featured Categories Section -->
        <?php if (!empty($featured_categories)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-primary bg-blue-soft d-inline-flex align-items-center justify-content-center" style="background:#eff6ff; width:36px; height:36px;">
                            <i class="las la-th-large fs-20"></i>
                        </span>
                        <span>Featured Categories</span>
                    </div>
                </div>

                <div class="aiz-carousel arrow-inactive-none arrow-x-0" 
                     data-items="6" data-xxl-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                     data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
                    <?php foreach ($featured_categories as $category): ?>
                        <div class="carousel-box px-2">
                            <a href="<?= base_url('category/' . esc($category['slug'])) ?>" class="category-card-modern">
                                <img src="<?= !empty($category['banner_img']) ? base_url($category['banner_img']) : base_url('assets/img/placeholder.jpg') ?>"
                                     alt="<?= esc($category['name']) ?>"
                                     onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                <div class="category-card-overlay">
                                    <h5 class="category-title-text">
                                        <?= esc($category['name']) ?>
                                        <i class="las la-arrow-right"></i>
                                    </h5>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 5. Featured Products Section -->
        <?php if (!empty($featured_products)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-warning bg-warning-soft d-inline-flex align-items-center justify-content-center" style="background:#fefce8; width:36px; height:36px;">
                            <i class="las la-star fs-20"></i>
                        </span>
                        <span>Featured Products</span>
                    </div>
                    <a href="<?= base_url('products') ?>" class="btn-view-all">
                        View All <i class="las la-arrow-right"></i>
                    </a>
                </div>

                <div class="row gutters-5">
                    <?php foreach (array_slice($featured_products, 0, 12) as $product): ?>
                        <?php 
                            $finalPrice = $productModel->calculateFinalPrice($product);
                            $unitPrice = (float)$product['unit_price'];
                        ?>
                        <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                            <div class="modern-product-card">
                                <?php if ($product['discount'] > 0): ?>
                                    <div class="discount-badge-modern">
                                        <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="img-wrap">
                                    <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                         alt="<?= esc($product['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    <div class="product-action-overlay">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="action-btn-circle" title="View Details">
                                            <i class="las la-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-modern">
                                    <h4 class="product-title-modern">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </h4>
                                    <div class="product-footer-row">
                                        <div class="product-price-wrap">
                                            <span class="price-current">৳<?= number_format($finalPrice, 0) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <span class="price-old">৳<?= number_format($unitPrice, 0) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn-quick-cart" title="Add to Cart" style="cursor: pointer;">
                                            <i class="las la-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 6. Promotional Coupon Section -->
        <div class="mb-5">
            <div class="coupon-section-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-center text-lg-left mb-3 mb-lg-0">
                        <div class="mb-3">
                            <span class="promo-tag-pill">
                                <i class="las la-tag"></i> Special Promotion
                            </span>
                        </div>
                        <h3 class="fs-24 fs-md-32 fw-800 text-white mb-2" style="letter-spacing: -0.02em;">Claim Exclusive Discount Offers</h3>
                        <p class="fs-14 text-white-50 mb-0" style="max-width: 580px;">Get the best price guaranteed on genuine routers, gadgets, and networking equipment today.</p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-right">
                        <a href="<?= base_url('products') ?>" class="btn btn-light rounded-pill fw-800 px-4 py-3 shadow-lg" style="color: #1e1b4b; transition: all 0.3s ease;">
                            Explore Deals <i class="las la-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6.5. Home Showcase Categories (Banner Left, Randomized Products Right) -->
        <?php if (!empty($home_showcase_categories)): ?>
            <?php foreach ($home_showcase_categories as $showcaseCat): ?>
                    <div class="mb-5">
                        <div class="section-title-wrap mb-3">
                            <div class="section-title-main">
                                <span class="p-2 rounded-circle text-primary d-inline-flex align-items-center justify-content-center" style="background:#eff6ff; width:36px; height:36px;">
                                    <i class="las la-layer-group fs-20" style="color:#2563eb;"></i>
                                </span>
                                <span><?= esc(html_entity_decode($showcaseCat['name'] ?? '')) ?></span>
                            </div>
                            <a href="<?= base_url('category/' . esc($showcaseCat['slug'] ?? '')) ?>" class="btn-view-all">
                                View All <i class="las la-arrow-right"></i>
                            </a>
                        </div>

                        <div class="row gutters-10">
                            <!-- Left Banner Card (Compact & Vertically Centered) -->
                            <div class="col-xl-3 col-lg-4 col-md-4 mb-3 mb-md-0 align-self-center">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-3 d-flex flex-column align-items-center text-center" style="border-radius: 16px; border: 1px solid #e2e8f0;">
                                    <?php 
                                        $bannerSrc = !empty($showcaseCat['banner_img']) ? base_url($showcaseCat['banner_img']) : (!empty($showcaseCat['cover_img']) ? base_url($showcaseCat['cover_img']) : base_url('assets/img/placeholder.jpg'));
                                    ?>
                                    <div class="position-relative overflow-hidden rounded-3 mb-3 w-100" style="aspect-ratio: 1 / 1; border-radius: 12px;">
                                        <img src="<?= $bannerSrc ?>" 
                                             alt="<?= esc($showcaseCat['name'] ?? '') ?>" 
                                             class="w-100 h-100 img-fit" 
                                             style="object-fit: cover; border-radius: 12px;"
                                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                    <div class="text-center w-100">
                                        <h5 class="fw-800 text-dark fs-15 mb-1" style="letter-spacing: -0.3px;"><?= esc(html_entity_decode($showcaseCat['name'] ?? '')) ?></h5>
                                        <p class="fs-12 text-muted mb-3">Explore items & deals</p>
                                        <a href="<?= base_url('category/' . esc($showcaseCat['slug'] ?? '')) ?>" class="btn btn-primary rounded-pill fw-700 px-3 py-2 fs-12 shadow-sm w-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                                            Shop Now <i class="las la-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Products Grid (10 Items - 2 Rows x 5 Cols) -->
                            <div class="col-xl-9 col-lg-8 col-md-8">
                                <div class="row gutters-5">
                                    <?php foreach (array_slice($showcaseCat['products'], 0, 10) as $product): ?>
                                        <?php 
                                            $finalPrice = $productModel->calculateFinalPrice($product);
                                            $unitPrice = (float)$product['unit_price'];
                                        ?>
                                        <div class="col-xl-1-5 col-lg-3 col-md-4 col-6 mb-2">
                                            <div class="modern-product-card" style="padding: 0.4rem;">
                                                <?php if (($product['discount'] ?? 0) > 0): ?>
                                                    <div class="discount-badge-modern" style="top: 8px; left: 8px; font-size: 0.65rem; padding: 0.2rem 0.5rem;">
                                                        <?= ($product['discount_type'] ?? '') === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="img-wrap" style="aspect-ratio: 1 / 1; height: auto;">
                                                    <img src="<?= !empty($product['thumbnail_img']) ? base_url($product['thumbnail_img']) : base_url('assets/img/placeholder.jpg') ?>"
                                                         alt="<?= esc($product['name']) ?>"
                                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                                </div>
                                                <div class="product-content-modern" style="padding-top: 0.35rem;">
                                                    <h4 class="product-title-modern" style="font-size: 0.8125rem; height: 2.1rem; margin-bottom: 0.25rem;">
                                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset">
                                                            <?= esc($product['name']) ?>
                                                        </a>
                                                    </h4>
                                                    <div class="product-footer-row" style="padding-top: 0.25rem;">
                                                        <div class="product-price-wrap">
                                                            <span class="price-current" style="font-size: 0.95rem;">৳<?= number_format($finalPrice, 0) ?></span>
                                                            <?php if ($finalPrice < $unitPrice): ?>
                                                                <span class="price-old" style="font-size: 0.75rem;">৳<?= number_format($unitPrice, 0) ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn-quick-cart" title="Add to Cart" style="cursor: pointer; width: 32px !important; height: 32px !important; font-size: 1rem !important; border-radius: 8px !important;">
                                                            <i class="las la-shopping-cart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- 7. New Arrivals Section -->
        <?php if (!empty($latest_products)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-success bg-success-soft d-inline-flex align-items-center justify-content-center" style="background:#f0fdf4; width:36px; height:36px;">
                            <i class="las la-sparkles fs-20" style="color:#16a34a;"></i>
                        </span>
                        <span>New Arrivals</span>
                    </div>
                    <a href="<?= base_url('products') ?>" class="btn-view-all">
                        View All <i class="las la-arrow-right"></i>
                    </a>
                </div>

                <div class="row gutters-5">
                    <?php foreach (array_slice($latest_products, 0, 24) as $product): ?>
                        <?php 
                            $finalPrice = $productModel->calculateFinalPrice($product);
                            $unitPrice = (float)$product['unit_price'];
                        ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                            <div class="modern-product-card" style="padding: 0.4rem;">
                                <?php if (($product['discount'] ?? 0) > 0): ?>
                                    <div class="discount-badge-modern" style="top: 8px; left: 8px; font-size: 0.65rem; padding: 0.2rem 0.5rem;">
                                        <?= ($product['discount_type'] ?? '') === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="img-wrap" style="aspect-ratio: 1 / 1; height: auto;">
                                    <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                         alt="<?= esc($product['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                </div>
                                <div class="product-content-modern" style="padding-top: 0.35rem;">
                                    <h4 class="product-title-modern" style="font-size: 0.8125rem; height: 2.1rem; margin-bottom: 0.25rem;">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </h4>
                                    <div class="product-footer-row" style="padding-top: 0.25rem;">
                                        <div class="product-price-wrap">
                                            <span class="price-current" style="font-size: 0.95rem;">৳<?= number_format($finalPrice, 0) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <span class="price-old" style="font-size: 0.75rem;">৳<?= number_format($unitPrice, 0) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn-quick-cart" title="Add to Cart" style="cursor: pointer; width: 32px !important; height: 32px !important; font-size: 1rem !important; border-radius: 8px !important;">
                                            <i class="las la-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>



        <!-- 9. Top Sellers Section -->
        <?php if (!empty($shops)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-info bg-info-soft d-inline-flex align-items-center justify-content-center" style="background:#e0f2fe; width:36px; height:36px;">
                            <i class="las la-store fs-20" style="color:#0284c7;"></i>
                        </span>
                        <span>Verified Top Sellers</span>
                    </div>
                </div>
                <div class="row gutters-16">
                    <?php foreach (array_slice($shops, 0, 6) as $shop): ?>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <div class="seller-card-modern">
                                <div class="seller-logo-wrap">
                                    <img src="<?= !empty($shop['logo_path']) ? base_url($shop['logo_path']) : base_url('assets/img/placeholder-rect.jpg') ?>"
                                         alt="<?= esc($shop['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-rect.jpg') ?>';">
                                </div>
                                <h6 class="fw-700 fs-13 mb-3 text-truncate w-100" style="color:#1e293b;"><?= esc($shop['name']) ?></h6>
                                <span class="btn btn-sm btn-soft-primary rounded-pill px-3 fw-700 fs-11" style="background:#eff6ff; color:#2563eb;">Visit Shop</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 10. Top Brands Section -->
        <?php if (!empty($brands)): ?>
            <div class="mb-5">
                <div class="section-title-wrap">
                    <div class="section-title-main">
                        <span class="p-2 rounded-circle text-primary d-inline-flex align-items-center justify-content-center" style="background:#f1f5f9; width:36px; height:36px;">
                            <i class="las la-award fs-20" style="color:#475569;"></i>
                        </span>
                        <span>Popular Brands</span>
                    </div>
                    <a href="<?= base_url('brands') ?>" class="btn-view-all">
                        View All Brands <i class="las la-arrow-right"></i>
                    </a>
                </div>
                <div class="row gutters-10">
                    <?php foreach (array_slice($brands, 0, 12) as $brand): ?>
                        <div class="col-lg-2 col-md-3 col-4 mb-3">
                            <a href="<?= base_url('brand/' . esc($brand['slug'])) ?>" class="brand-chip-card">
                                <img src="<?= !empty($brand['logo_path']) ? base_url($brand['logo_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                     alt="<?= esc($brand['name']) ?>"
                                     onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                <span class="brand-name-text text-truncate w-100 text-center"><?= esc($brand['name']) ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
