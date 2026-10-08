<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<style>
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .filter-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .filter-cat-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 320px;
        overflow-y: auto;
    }
    .filter-cat-item {
        margin-bottom: 0.35rem;
    }
    .filter-cat-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.45rem 0.65rem;
        border-radius: 8px;
        color: #334155;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }
    .filter-cat-link:hover, .filter-cat-link.active {
        background: #fff1f2;
        color: #ee1c25;
    }
    .filter-cat-link.active {
        font-weight: 800;
    }
    .filter-cat-count {
        font-size: 0.75rem;
        background: #f1f5f9;
        color: #64748b;
        padding: 2px 8px;
        border-radius: 50px;
        font-weight: 700;
    }
    .filter-cat-link.active .filter-cat-count {
        background: #fecdd3;
        color: #dc2626;
    }
    .catalog-product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 0.65rem;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease, border-color 0.35s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
    }
    .catalog-product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 30px -8px rgba(238, 28, 37, 0.18);
        border-color: #ee1c25;
    }
    .catalog-product-card .img-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        background: #f8fafc;
        margin-bottom: 0.65rem;
    }
    .catalog-product-card .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }
    .catalog-product-card:hover .img-box img {
        transform: scale(1.08);
    }
    .catalog-product-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        line-height: 1.35;
        height: 2.3rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: color 0.2s ease;
    }
    .catalog-product-card:hover .catalog-product-title {
        color: #ee1c25;
    }
    .catalog-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 0.5rem;
        border-top: 1px dashed #f1f5f9;
    }
    .catalog-price-current {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ee1c25;
    }
    .catalog-price-old {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.35rem;
        font-weight: 600;
    }
    .subcat-tree-list {
        padding-left: 1.25rem;
        margin-top: 0.25rem;
        border-left: 2px solid #f1f5f9;
    }
</style>

<main class="py-4">
    <div class="container">
        <!-- Header Banner Block -->
        <div class="bg-white border shadow-sm p-4 mb-4" style="border-radius: 16px; border-color: #e2e8f0 !important;">
            <div class="d-flex align-items-center">
                <div class="mr-3 p-3 rounded-circle flex-shrink-0" style="background: linear-gradient(135deg, #ee1c25 0%, #ff5252 100%); color: #ffffff; width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;">
                    <i class="las la-shopping-bag fs-24"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 0.75rem;">
                        <h3 class="fs-22 fw-800 text-dark mb-0">
                            <?= !empty($keyword) ? 'Search: "' . esc($keyword) . '"' : esc($category_name ?? 'Products Catalog') ?>
                        </h3>
                        <span style="display: inline-flex; align-items: center; width: auto; height: auto; padding: 4px 12px; font-size: 12px; font-weight: 700; color: #ee1c25; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 50px; white-space: nowrap;">
                            <i class="las la-box mr-1"></i> <?= $total_items ?? count($products) ?> Products Available
                        </span>
                    </div>
                    <div class="mt-1">
                        <span class="fs-13 text-muted">Browse verified products and items available in store</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subcategories Bar (if any) -->
        <?php if (!empty($subcategories)): ?>
            <div class="bg-white border shadow-sm p-3 mb-4" style="border-radius: 14px; border-color: #e2e8f0 !important;">
                <div class="d-flex align-items-center mb-2">
                    <i class="las la-sitemap text-primary mr-1 fs-16"></i>
                    <span class="fs-12 text-dark fw-700 text-uppercase" style="letter-spacing: 0.5px;">Subcategories in <?= esc($category_name ?? '') ?>:</span>
                </div>
                <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                    <?php foreach ($subcategories as $sub): ?>
                        <a href="<?= base_url('category/' . esc($sub['slug'])) ?>" class="btn btn-xs btn-soft-secondary rounded-pill font-weight-bold px-3 py-1 fs-12 border">
                            <?= esc($sub['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Left Filter Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <form action="<?= base_url('products') ?>" method="GET" id="catalogFilterForm">
                    <?php if (!empty($keyword)): ?>
                        <input type="hidden" name="keyword" value="<?= esc($keyword) ?>">
                    <?php endif; ?>

                    <!-- Filter Title Box -->
                    <div class="filter-card">
                        <div class="filter-title mb-3">
                            <span><i class="las la-filter text-primary mr-1"></i> Filter Products</span>
                            <?php if (!empty($selected_cat_id) || !empty($selected_brand_id) || !empty($min_price) || !empty($max_price) || !empty($discounted_only) || !empty($keyword)): ?>
                                <a href="<?= base_url('products') ?>" class="text-danger fs-12 font-weight-bold text-decoration-none">
                                    <i class="las la-undo mr-1"></i> Clear All
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- 1. Categories Filter -->
                        <div class="mb-4">
                            <label class="fs-12 fw-700 text-uppercase text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                Categories
                            </label>
                            <ul class="filter-cat-list">
                                <li class="filter-cat-item">
                                    <a href="<?= base_url('products' . (!empty($keyword) ? '?keyword='.urlencode($keyword) : '')) ?>" class="filter-cat-link <?= empty($selected_cat_id) ? 'active' : '' ?>">
                                        <span><i class="las la-border-all mr-1"></i> All Categories</span>
                                    </a>
                                </li>
                                <?php foreach ($categories as $c): ?>
                                    <?php $isCatActive = ($selected_cat_id == $c['id']); ?>
                                    <li class="filter-cat-item">
                                        <a href="<?= base_url('products?cat_id=' . $c['id'] . (!empty($keyword) ? '&keyword='.urlencode($keyword) : '')) ?>" class="filter-cat-link <?= $isCatActive ? 'active' : '' ?>">
                                            <span class="text-truncate"><?= esc($c['name']) ?></span>
                                            <span class="filter-cat-count"><?= $c['product_count'] ?? 0 ?></span>
                                        </a>
                                        <?php if (!empty($c['subcategories']) && ($isCatActive || true)): ?>
                                            <ul class="subcat-tree-list list-unstyled mb-1">
                                                <?php foreach (array_slice($c['subcategories'], 0, 8) as $sc): ?>
                                                    <li>
                                                        <a href="<?= base_url('category/' . esc($sc['slug'])) ?>" class="filter-cat-link py-1 fs-12 <?= ($selected_cat_id == $sc['id']) ? 'active text-danger' : 'text-muted' ?>">
                                                            <span class="text-truncate">• <?= esc($sc['name']) ?></span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- 2. Price Range Filter -->
                        <div class="mb-4 pt-3 border-top">
                            <label class="fs-12 fw-700 text-uppercase text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                Price Range (৳)
                            </label>
                            <div class="form-row align-items-center">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control form-control-sm rounded-lg" placeholder="Min" value="<?= esc($min_price ?? '') ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control form-control-sm rounded-lg" placeholder="Max" value="<?= esc($max_price ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Brands Filter -->
                        <?php if (!empty($brands)): ?>
                            <div class="mb-4 pt-3 border-top">
                                <label class="fs-12 fw-700 text-uppercase text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                    Brands
                                </label>
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="brand_all" name="brand_id" value="" class="custom-control-input" <?= empty($selected_brand_id) ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="custom-control-label fs-13 font-weight-bold text-dark" for="brand_all">All Brands</label>
                                </div>
                                <?php foreach ($brands as $b): ?>
                                    <div class="custom-control custom-radio mb-1">
                                        <input type="radio" id="brand_<?= $b['id'] ?>" name="brand_id" value="<?= $b['id'] ?>" class="custom-control-input" <?= ($selected_brand_id == $b['id']) ? 'checked' : '' ?> onchange="this.form.submit()">
                                        <label class="custom-control-label fs-13 text-secondary" for="brand_<?= $b['id'] ?>">
                                            <?= esc($b['name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- 4. Product Features & Perks -->
                        <div class="mb-3 pt-3 border-top">
                            <label class="fs-12 fw-700 text-uppercase text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                Features & Offers
                            </label>
                            
                            <!-- On Sale -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="discounted_only" name="discounted" value="1" <?= !empty($discounted_only) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 font-weight-bold text-danger" for="discounted_only">
                                    <i class="las la-percentage mr-1"></i> On Sale / Discounted
                                </label>
                            </div>

                            <!-- In Stock Only -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="in_stock_only" name="in_stock" value="1" <?= !empty($in_stock) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="in_stock_only">
                                    <i class="las la-check-circle text-success mr-1"></i> In Stock Only
                                </label>
                            </div>

                            <!-- Cash on Delivery -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="cod_only" name="cod" value="1" <?= !empty($cod) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="cod_only">
                                    <i class="las la-money-bill-wave text-primary mr-1"></i> Cash on Delivery
                                </label>
                            </div>

                            <!-- Free Shipping -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="free_shipping_only" name="free_shipping" value="1" <?= !empty($free_shipping) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="free_shipping_only">
                                    <i class="las la-shipping-fast text-info mr-1"></i> Free Shipping
                                </label>
                            </div>

                            <!-- Featured Products -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="featured_only" name="featured" value="1" <?= !empty($featured) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="featured_only">
                                    <i class="las la-star text-warning mr-1"></i> Featured Items
                                </label>
                            </div>

                            <!-- Today's Deals -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="todays_deal_only" name="todays_deal" value="1" <?= !empty($todays_deal) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="todays_deal_only">
                                    <i class="las la-fire text-danger mr-1"></i> Today's Deals
                                </label>
                            </div>

                            <!-- Warranty -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="warranty_only" name="warranty" value="1" <?= !empty($warranty) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="warranty_only">
                                    <i class="las la-shield-alt text-success mr-1"></i> Official Warranty
                                </label>
                            </div>

                            <!-- Wholesale -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="wholesale_only" name="wholesale" value="1" <?= !empty($wholesale) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="wholesale_only">
                                    <i class="las la-boxes text-purple mr-1"></i> Wholesale Available
                                </label>
                            </div>
                        </div>

                        <!-- 5. Rating Filter -->
                        <div class="mb-3 pt-3 border-top">
                            <label class="fs-12 fw-700 text-uppercase text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                Rating
                            </label>
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="rating_all" name="min_rating" value="" class="custom-control-input" <?= empty($min_rating) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-secondary" for="rating_all">All Ratings</label>
                            </div>
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="rating_4" name="min_rating" value="4" class="custom-control-input" <?= ($min_rating == 4) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-warning font-weight-bold" for="rating_4">
                                    ★★★★☆ & Up (4.0+)
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="rating_3" name="min_rating" value="3" class="custom-control-input" <?= ($min_rating == 3) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="custom-control-label fs-13 text-warning font-weight-bold" for="rating_3">
                                    ★★★☆☆ & Up (3.0+)
                                </label>
                            </div>
                        </div>

                        <!-- Submit Filter Button -->
                        <button type="submit" class="btn btn-primary btn-block fw-700 rounded-pill mt-3 py-2 shadow-sm" style="background-color: #ee1c25; border-color: #ee1c25;">
                            <i class="las la-check-circle mr-1"></i> Apply Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Product Listing Grid -->
            <div class="col-lg-9 col-md-8">
                <!-- Top Sorting & Count Toolbar -->
                <div class="bg-white border rounded-lg p-3 mb-4 shadow-sm d-flex align-items-center justify-content-between flex-wrap" style="border-color: #e2e8f0 !important; gap: 0.75rem;">
                    <span class="fs-14 font-weight-bold text-dark">
                        Showing <span class="text-danger"><?= count($products) ?></span> of <span class="text-dark"><?= $total_items ?? 0 ?></span> items
                    </span>

                    <div class="d-flex align-items-center">
                        <label for="sortBySelect" class="fs-13 text-muted mr-2 mb-0 fw-600">Sort By:</label>
                        <select id="sortBySelect" class="form-control form-control-sm rounded-pill font-weight-bold border-gray-300" style="width: auto; min-width: 160px;" onchange="applySort(this.value)">
                            <option value="latest" <?= ($sort_by ?? '') == 'latest' ? 'selected' : '' ?>>Newest Arrivals</option>
                            <option value="price_low_high" <?= ($sort_by ?? '') == 'price_low_high' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high_low" <?= ($sort_by ?? '') == 'price_high_low' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="name_asc" <?= ($sort_by ?? '') == 'name_asc' ? 'selected' : '' ?>>Name: A to Z</option>
                        </select>
                    </div>
                </div>

                <?php if (!empty($products)): ?>
                    <div class="row gutters-10">
                        <?php foreach ($products as $product): ?>
                            <?php 
                                $finalPrice = $productModel->calculateFinalPrice($product);
                                $unitPrice = (float)$product['unit_price'];
                            ?>
                            <div class="col-xl-3 col-lg-4 col-6 mb-3">
                                <div class="catalog-product-card">
                                    <?php if ($product['discount'] > 0): ?>
                                        <div class="discount-badge-modern" style="top: 10px; left: 10px; font-size: 0.65rem; padding: 0.2rem 0.55rem;">
                                            <?= $product['discount_type'] === 'percent' ? '-' . (int)$product['discount'] . '%' : 'OFF' ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="img-box">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>">
                                            <img src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>"
                                                 alt="<?= esc($product['name']) ?>"
                                                 onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                        </a>
                                    </div>

                                    <h4 class="catalog-product-title">
                                        <a href="<?= base_url('product/' . esc($product['slug'])) ?>" class="text-reset">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </h4>

                                    <div class="catalog-price-row">
                                        <div>
                                            <span class="catalog-price-current">৳<?= number_format($finalPrice, 0) ?></span>
                                            <?php if ($finalPrice < $unitPrice): ?>
                                                <span class="catalog-price-old">৳<?= number_format($unitPrice, 0) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" onclick="addToCartDirect(<?= $product['id'] ?>, event)" class="btn-quick-cart" title="Add to Cart" style="cursor: pointer; width: 34px !important; height: 34px !important; font-size: 1.05rem !important; border-radius: 10px !important;">
                                            <i class="las la-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination Controls -->
                    <?php if (!empty($total_pages) && $total_pages > 1): ?>
                        <div class="d-flex justify-content-center align-items-center mt-4 pt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0 align-items-center">
                                    <?php if ($current_page > 1): ?>
                                        <li class="page-item mr-1">
                                            <a class="page-item-link px-3 py-2 border rounded-pill text-dark fw-700 fs-13 text-decoration-none" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>">
                                                <i class="las la-angle-left mr-1"></i> Prev
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item mx-1">
                                            <a class="page-item-link px-3 py-2 border rounded-pill fw-700 fs-13 text-decoration-none <?= $i == $current_page ? 'bg-danger text-white border-danger shadow-sm' : 'bg-white text-dark border-light' ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($current_page < $total_pages): ?>
                                        <li class="page-item ml-1">
                                            <a class="page-item-link px-3 py-2 border rounded-pill text-dark fw-700 fs-13 text-decoration-none" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                                Next <i class="las la-angle-right ml-1"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bg-white rounded-lg border shadow-sm text-center py-5 px-3">
                        <div class="mb-3 d-inline-block p-3 rounded-circle bg-light text-muted">
                            <i class="las la-search-location fs-48" style="color: #94a3b8;"></i>
                        </div>
                        <h4 class="fw-800 text-dark mb-1">No products found</h4>
                        <p class="text-secondary fs-14 mb-4">We couldn't find any products matching your requested criteria.</p>
                        <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg fw-700 px-5 rounded-pill shadow-sm" style="background-color: #ee1c25; border-color: #ee1c25;">
                            Explore All Products
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
    function applySort(val) {
        const form = document.getElementById('catalogFilterForm');
        let sortInput = form.querySelector('input[name="sort_by"]');
        if (!sortInput) {
            sortInput = document.createElement('input');
            sortInput.type = 'hidden';
            sortInput.name = 'sort_by';
            form.appendChild(sortInput);
        }
        sortInput.value = val;
        form.submit();
    }
</script>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
