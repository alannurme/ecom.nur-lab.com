<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<style>
    #section_featured .slick-slider .slick-list{
        background: #fff;
    }
    #section_featured .slick-slider .slick-list .slick-slide {
        margin-bottom: -5px;
    }
    @media (max-width: 575px){
        #section_featured .slick-slider .slick-list .slick-slide {
            margin-bottom: -4px;
        }
    }
</style>

<!-- Sliders Area -->
<div class="home-banner-area mb-3">
    <div class="p-0">
        <div class="home-slider slider-full">
            <?php if (!empty($sliders)): ?>
                <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-autoplay="true" data-infinite="true">
                    <?php foreach ($sliders as $key => $slider): ?>
                        <div class="carousel-box">
                            <a href="#">
                                <div class="d-block mw-100 img-fit overflow-hidden h-180px h-md-320px h-lg-460px h-xl-553px overflow-hidden">
                                    <img class="img-fit h-100 m-auto has-transition"
                                         src="<?= base_url($slider['file_name']) ?>"
                                         alt="<?= esc($site_name) ?> promo"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-rect.jpg') ?>';">
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Flash Deal / Today's Deals Section -->
<?php if (!empty($todays_deals)): ?>
    <section class="mb-2 mb-md-3 mt-2 mt-md-3" id="flash_deal">
        <div class="container">
            <div class="d-flex flex-wrap mb-2 mb-md-3 align-items-baseline justify-content-between">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="d-inline-block text-dark">Flash Sale</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24" class="ml-3">
                        <path id="Path_28795" data-name="Path 28795"
                            d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z"
                            transform="translate(-15 -5)" fill="#fcc201" />
                    </svg>
                </h3>
                <div>
                    <div class="text-dark d-flex align-items-center mb-0">
                        <a href="<?= base_url('products') ?>" class="fs-10 fs-md-12 fw-700 has-transition text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary mr-3">
                            View All Flash Sale
                        </a>
                    </div>
                </div>
            </div>

            <div class="row no-gutters align-items-center bg-white border">
                <div class="col-xxl-12 col-lg-12">
                    <div class="aiz-carousel border-top arrow-inactive-none arrow-x-0"
                        data-rows="2" data-items="5" data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2"
                        data-sm-items="2.5" data-xs-items="1.7" data-arrows="true" data-dots="false">
                        <?php foreach ($todays_deals as $key => $product): ?>
                            <?php 
                                $finalPrice = $productModel->calculateFinalPrice($product);
                                $unitPrice = (float)$product['unit_price'];
                            ?>
                            <div class="carousel-box bg-white border-left border-bottom">
                                <div class="h-100px h-md-200px h-lg-auto flash-deal-item position-relative text-center has-transition hov-shadow-out z-1 p-2">
                                    <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="d-block py-md-2 overflow-hidden hov-scale-img" title="<?= esc($product['name']) ?>">
                                        <div class="d-block h-100 position-relative image-hover-effect">
                                            <img class="lazyload h-60px h-md-100px h-lg-120px mw-100 mx-auto has-transition product-main-image"
                                                src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                                alt="<?= esc($product['name']) ?>"
                                                onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                        </div>  
                                        <div class="fs-10 fs-md-14 mt-md-2 text-center h-md-48px has-transition overflow-hidden pt-md-2 flash-deal-price lh-1-5">
                                            <span class="d-block text-primary fw-700">৳<?= number_format($finalPrice, 2) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <del class="d-block fw-400 text-secondary">৳<?= number_format($unitPrice, 2) ?></del>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Featured Categories -->
<?php if (!empty($featured_categories)): ?>
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <div class="bg-white">
                <div class="d-flex mt-2 mt-md-3 mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span>Featured Categories</span>
                    </h3>
                </div>
            </div>
            <div class="bg-white px-sm-3">
                <div class="aiz-carousel sm-gutters-17" data-items="4" data-xxl-items="4" data-xl-items="3.5"
                    data-lg-items="3" data-md-items="2" data-sm-items="2" data-xs-items="1" data-arrows="true"
                    data-dots="false" data-autoplay="false" data-infinite="true">
                    <?php foreach ($featured_categories as $key => $category): ?>
                        <div class="carousel-box position-relative p-0 has-transition border-right border-top border-bottom <?= $key == 0 ? 'border-left' : '' ?>">
                            <div class="h-200px h-sm-250px h-md-340px">
                                <div class="h-100 w-100 w-xl-auto position-relative hov-scale-img overflow-hidden">
                                    <div class="position-absolute h-100 w-100 overflow-hidden">
                                        <img src="<?= !empty($category['banner_img']) ? base_url($category['banner_img']) : base_url('assets/img/placeholder.jpg') ?>"
                                            alt="<?= esc($category['name']) ?>"
                                            class="img-fit h-100 has-transition"
                                            onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                    <div class="pb-4 px-4 absolute-bottom-left has-transition h-50 w-100 d-flex flex-column align-items-center justify-content-end"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.5) 50%,rgba(0,0,0,0) 100%) !important;">
                                        <div class="w-100">
                                            <a class="fs-16 fw-700 text-white animate-underline-white home-category-name d-flex align-items-center hov-column-gap-1"
                                                href="<?= base_url('category/' . esc($category['slug'])) ?>"
                                                style="width: max-content;">
                                                <?= esc($category['name']) ?>&nbsp;
                                                <i class="las la-angle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Featured Products Section -->
<?php if (!empty($featured_products)): ?>
    <div id="section_featured" class="pt-2 pt-md-3" style="background: #f5f5fa;">
        <div class="container">
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span>Featured Products</span>
                </h3>
                <a href="<?= base_url('products') ?>" class="fs-10 fs-md-12 fw-700 text-primary">View All Products <i class="las la-angle-right"></i></a>
            </div>
            <div class="row gutters-16">
                <?php foreach ($featured_products as $product): ?>
                    <?php 
                        $finalPrice = $productModel->calculateFinalPrice($product);
                        $unitPrice = (float)$product['unit_price'];
                    ?>
                    <div class="col-xxl-3 col-lg-3 col-md-4 col-6 mb-3">
                        <div class="aiz-card-box h-100 bg-white p-2 border position-relative has-transition hov-shadow-out">
                            <div class="position-relative overflow-hidden text-center" style="height: 180px;">
                                <?php if ($product['discount'] > 0): ?>
                                    <span class="badge badge-danger position-absolute left-0 top-0 fs-11 px-2 py-1 z-2">
                                        <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                    </span>
                                <?php endif; ?>
                                <a href="<?= base_url('product/' . esc($product['slug'])) ?>">
                                    <img class="img-fit h-100 mw-100 has-transition"
                                         src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                         alt="<?= esc($product['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                </a>
                            </div>
                            <div class="p-2 text-center">
                                <h4 class="fs-14 fw-700 text-dark text-truncate-2 mb-2" style="height: 40px; overflow: hidden;">
                                    <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset hov-text-primary">
                                        <?= esc($product['name']) ?>
                                    </a>
                                </h4>
                                <div class="fs-14 fw-700 text-primary">
                                    <span>৳<?= number_format($finalPrice, 2) ?></span>
                                    <?php if ($finalPrice < $unitPrice): ?>
                                        <del class="fs-12 text-muted fw-400 ml-2">৳<?= number_format($unitPrice, 2) ?></del>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- New Products Section -->
<?php if (!empty($latest_products)): ?>
    <section class="mb-2 mb-md-3 mt-2 mt-md-3" id="section_newest">
        <div class="container">
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span>New Products / Arrivals</span>
                </h3>
                <a class="text-primary fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="<?= base_url('products') ?>">View All</a>
            </div>
            <div class="row gutters-16">
                <?php foreach (array_slice($latest_products, 0, 8) as $product): ?>
                    <?php 
                        $finalPrice = $productModel->calculateFinalPrice($product);
                        $unitPrice = (float)$product['unit_price'];
                    ?>
                    <div class="col-xxl-3 col-lg-3 col-md-4 col-6 mb-3">
                        <div class="aiz-card-box h-100 bg-white p-2 border position-relative has-transition hov-shadow-out">
                            <div class="position-relative overflow-hidden text-center" style="height: 180px;">
                                <?php if ($product['discount'] > 0): ?>
                                    <span class="badge badge-danger position-absolute left-0 top-0 fs-11 px-2 py-1 z-2">
                                        <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                    </span>
                                <?php endif; ?>
                                <a href="<?= base_url('product/' . esc($product['slug'])) ?>">
                                    <img class="img-fit h-100 mw-100 has-transition"
                                         src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                         alt="<?= esc($product['name']) ?>"
                                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                </a>
                            </div>
                            <div class="p-2 text-center">
                                <h4 class="fs-14 fw-700 text-dark text-truncate-2 mb-2" style="height: 40px; overflow: hidden;">
                                    <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset hov-text-primary">
                                        <?= esc($product['name']) ?>
                                    </a>
                                </h4>
                                <div class="fs-14 fw-700 text-primary">
                                    <span>৳<?= number_format($finalPrice, 2) ?></span>
                                    <?php if ($finalPrice < $unitPrice): ?>
                                        <del class="fs-12 text-muted fw-400 ml-2">৳<?= number_format($unitPrice, 2) ?></del>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Coupon Section -->
<div class="mt-2 mt-md-3" style="background-color: #292933">
    <div class="container">
        <div class="position-relative py-5">
            <div class="text-center text-xl-left position-relative z-5">
                <div class="d-lg-flex align-items-center">
                    <div class="mb-3 mb-lg-0 mr-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="75" viewBox="0 0 109.602 93.34">
                            <g fill="none" stroke="#fff" stroke-width="2">
                                <path d="M10,10 H90 V65 H10 Z" />
                                <circle cx="50" cy="37" r="15" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fs-36 fw-400 text-white mb-2">Exclusive Discount Coupons</h5>
                        <h5 class="fs-20 fw-400 text-gray mb-4">Get special discount offers on your favorite items</h5>
                        <div>
                            <a href="<?= base_url('products') ?>" class="btn text-white border border-width-2 fs-16 px-5" style="border-radius: 28px; background: rgba(255, 255, 255, 0.2);">
                                View All Coupons
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Wise Products Showcase -->
<?php if (!empty($category_wise_products)): ?>
    <div id="section_home_categories" style="background: #f5f5fa;" class="py-4">
        <?php foreach ($category_wise_products as $item): ?>
            <section class="py-3">
                <div class="container">
                    <div class="d-sm-flex bg-white border">
                        <div class="px-0 pt-0 pb-3 p-sm-4">
                            <div class="w-sm-260px h-260px mx-auto">
                                <a href="<?= base_url('category/' . esc($item['category']['slug'])) ?>" class="d-block h-100 w-100 w-xl-auto hov-scale-img overflow-hidden home-category-banner">
                                    <span class="position-absolute h-100 w-100 overflow-hidden">
                                        <img src="<?= !empty($item['category']['banner_img']) ? base_url($item['category']['banner_img']) : base_url('assets/img/placeholder.jpg') ?>"
                                            alt="<?= esc($item['category']['name']) ?>"
                                            class="img-fit h-100 has-transition"
                                            onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </span>
                                    <span class="home-category-name fs-15 fw-600 text-white text-center">
                                        <span><?= esc($item['category']['name']) ?></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="p-0 p-sm-4 w-100 overflow-hidden">
                            <div class="row gutters-16">
                                <?php foreach ($item['products'] as $product): ?>
                                    <?php 
                                        $finalPrice = $productModel->calculateFinalPrice($product);
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <div class="aiz-card-box p-2 border text-center h-100">
                                            <a href="<?= base_url('product/' . esc($product['slug'])) ?>">
                                                <img class="img-fit h-120px mw-100 mx-auto"
                                                    src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                                    alt="<?= esc($product['name']) ?>"
                                                    onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                            </a>
                                            <h4 class="fs-13 fw-600 text-dark text-truncate-2 mt-2" style="height: 36px; overflow: hidden;">
                                                <?= esc($product['name']) ?>
                                            </h4>
                                            <div class="fs-14 fw-700 text-primary mt-1">
                                                <span>৳<?= number_format($finalPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Top Sellers -->
<?php if (!empty($shops)): ?>
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="pb-3">Top Sellers</span>
                </h3>
            </div>
            <div class="row gutters-16">
                <?php foreach ($shops as $shop): ?>
                    <div class="col-lg-2 col-md-4 col-6 mb-3">
                        <div class="carousel-box h-100 position-relative text-center border p-3 bg-white has-transition hov-animate-outline">
                            <div class="mx-auto size-80px rounded-circle overflow-hidden border mb-3">
                                <img src="<?= !empty($shop['logo_path']) ? base_url($shop['logo_path']) : base_url('assets/img/placeholder-rect.jpg') ?>"
                                    alt="<?= esc($shop['name']) ?>"
                                    class="img-fit h-100 w-100"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder-rect.jpg') ?>';">
                            </div>
                            <h2 class="fs-14 fw-700 text-dark text-truncate mb-2"><?= esc($shop['name']) ?></h2>
                            <span class="btn btn-soft-primary btn-xs rounded-pill px-3">Visit Store</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Top Brands -->
<?php if (!empty($brands)): ?>
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">Top Brands</h3>
                <div class="d-flex">
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="<?= base_url('brands') ?>">View All Brands</a>
                </div>
            </div>
            <div class="bg-white px-3">
                <div class="row row-cols-xxl-6 row-cols-xl-6 row-cols-lg-4 row-cols-md-4 row-cols-3 gutters-16 border-top border-left">
                    <?php foreach ($brands as $brand): ?>
                        <div class="col text-center border-right border-bottom hov-scale-img has-transition hov-shadow-out z-1 p-3">
                            <a href="<?= base_url('brand/' . esc($brand['slug'])) ?>" class="d-block">
                                <img src="<?= !empty($brand['logo_path']) ? base_url($brand['logo_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                    class="lazyload h-60px mx-auto has-transition p-2 mw-100"
                                    alt="<?= esc($brand['name']) ?>"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2 mb-0">
                                    <?= esc($brand['name']) ?>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
