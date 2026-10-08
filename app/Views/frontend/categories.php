<?= view('frontend/layouts/header', ['site_name' => $site_name, 'categories' => $categories]) ?>

<style>
    .category-page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 20px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
    }
    .category-page-header::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(238, 28, 37, 0.22) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .category-main-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease, border-color 0.35s ease;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .category-main-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px -8px rgba(238, 28, 37, 0.16);
        border-color: #ee1c25;
    }
    .category-card-banner {
        height: 110px;
        width: 100%;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        position: relative;
        overflow: hidden;
    }
    .category-card-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .category-main-card:hover .category-card-banner img {
        transform: scale(1.08);
    }
    .category-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: #ffffff;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -28px;
        margin-left: 1.25rem;
        position: relative;
        z-index: 2;
        overflow: hidden;
    }
    .category-icon-box img {
        max-width: 36px;
        max-height: 36px;
        object-fit: contain;
    }
    .subcategory-chip {
        font-size: 0.78rem;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
        transition: all 0.2s ease;
        display: inline-block;
        text-decoration: none !important;
    }
    .subcategory-chip:hover {
        color: #ee1c25;
        background: #fff1f2;
        border-color: #fecdd3;
    }
    .category-action-btn {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 700;
        font-size: 0.85rem;
        border-top: 1px solid #f1f5f9;
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
        text-decoration: none !important;
        margin-top: auto;
    }
    .category-main-card:hover .category-action-btn {
        background: #ee1c25;
        color: #ffffff;
    }
    .category-action-btn i {
        transition: transform 0.25s ease;
    }
    .category-main-card:hover .category-action-btn i {
        transform: translateX(4px);
    }
</style>

<main class="py-4">
    <div class="container">
        <!-- Header Banner Section -->
        <div class="category-page-header">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <div class="d-flex align-items-center mb-2" style="gap: 0.5rem;">
                        <span style="display: inline-flex; align-items: center; background: rgba(238, 28, 37, 0.2); color: #ff6b6b; border: 1px solid rgba(238, 28, 37, 0.3); padding: 3px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="las la-layer-group mr-1"></i> Catalog Directory
                        </span>
                    </div>
                    <h2 class="fs-28 fw-800 text-white mb-2">Explore All Product Categories</h2>
                    <p class="text-white-50 mb-0 fs-14">Browse our comprehensive list of verified product categories and subcategories to find exactly what you need.</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <div class="d-inline-flex flex-wrap justify-content-lg-end" style="gap: 0.75rem;">
                        <div class="bg-white-10 backdrop-blur px-3 py-2 rounded-lg border border-white-10 text-left">
                            <span class="d-block fs-11 text-white-50 font-weight-bold uppercase">Total Categories</span>
                            <span class="fs-18 fw-800 text-white"><?= count($categories) ?> Main Categories</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Filter Input -->
        <div class="mb-4">
            <div class="position-relative max-w-500px">
                <i class="las la-search position-absolute text-muted fs-18" style="left: 14px; top: 50%; transform: translateY(-50%); z-index: 5;"></i>
                <input type="text" id="categorySearchInput" class="form-control form-control-lg pl-5" placeholder="Search categories..." style="border-radius: 50px; border-color: #cbd5e1; font-size: 0.95rem; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="row gutters-15" id="categoryGrid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <?php 
                        $subNames = array_column($cat['subcategories'] ?? [], 'name');
                        $searchTerms = strtolower(esc($cat['name']) . ' ' . implode(' ', $subNames));
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4 category-card-item" data-name="<?= esc($searchTerms) ?>">
                        <div class="category-main-card">
                            <!-- Banner Image -->
                            <div class="category-card-banner">
                                <?php if (!empty($cat['banner_img'])): ?>
                                    <img src="<?= base_url($cat['banner_img']) ?>" alt="<?= esc($cat['name']) ?>" onerror="this.style.display='none';">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                        <i class="las la-tags text-slate-400 fs-36" style="opacity: 0.3;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Icon Box Overlay -->
                            <div class="category-icon-box">
                                <?php if (!empty($cat['icon_img'])): ?>
                                    <img src="<?= base_url($cat['icon_img']) ?>" alt="<?= esc($cat['name']) ?>" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                <?php else: ?>
                                    <i class="las la-shapes text-primary fs-28"></i>
                                <?php endif; ?>
                            </div>

                            <!-- Body Content -->
                            <div class="p-4 pt-3 flex-grow-1 d-flex flex-column">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h3 class="fs-18 fw-800 text-dark mb-0 text-truncate mr-2">
                                        <a href="<?= base_url('category/' . esc($cat['slug'])) ?>" class="text-dark text-reset">
                                            <?= esc($cat['name']) ?>
                                        </a>
                                    </h3>
                                    <span style="display: inline-flex; align-items: center; width: auto; height: auto; padding: 3px 10px; font-size: 11px; font-weight: 700; color: #ee1c25; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 50px; white-space: nowrap; flex-shrink: 0;">
                                        <?= $cat['product_count'] ?? 0 ?> Items
                                    </span>
                                </div>

                                <!-- Subcategories -->
                                <?php if (!empty($cat['subcategories'])): ?>
                                    <div class="mt-2 mb-3">
                                        <span class="fs-11 text-muted fw-700 text-uppercase d-block mb-2" style="letter-spacing: 0.5px;">All Subcategories (<?= count($cat['subcategories']) ?>)</span>
                                        <div class="d-flex flex-wrap subcat-container" style="gap: 0.4rem;">
                                            <?php 
                                                $subLimit = 6;
                                                $subCount = count($cat['subcategories']);
                                            ?>
                                            <?php foreach ($cat['subcategories'] as $index => $sub): ?>
                                                <a href="<?= base_url('category/' . esc($sub['slug'])) ?>" class="subcategory-chip <?= $index >= $subLimit ? 'd-none extra-subcat' : '' ?>">
                                                    <?= esc($sub['name']) ?>
                                                </a>
                                            <?php endforeach; ?>
                                            <?php if ($subCount > $subLimit): ?>
                                                <button type="button" class="subcategory-chip text-primary fw-700 border-0 btn-toggle-subs" style="cursor: pointer;" onclick="toggleSubcategories(this)">
                                                    +<?= ($subCount - $subLimit) ?> More
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2 mb-3">
                                        <span class="fs-12 text-muted italic">Explore verified items in this collection</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Action Footer -->
                            <a href="<?= base_url('category/' . esc($cat['slug'])) ?>" class="category-action-btn">
                                <span>Browse Category</span>
                                <i class="las la-arrow-right fs-16"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="las la-folder-open fs-64 text-muted mb-3 d-block"></i>
                    <h5 class="fw-700 text-dark">No Categories Found</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    function toggleSubcategories(btn) {
        const container = btn.closest('.subcat-container');
        const extras = container.querySelectorAll('.extra-subcat');
        const isExpanded = btn.getAttribute('data-expanded') === 'true';

        if (isExpanded) {
            extras.forEach(el => el.classList.add('d-none'));
            btn.textContent = '+' + extras.length + ' More';
            btn.setAttribute('data-expanded', 'false');
        } else {
            extras.forEach(el => el.classList.remove('d-none'));
            btn.textContent = 'Show Less';
            btn.setAttribute('data-expanded', 'true');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('categorySearchInput');
        const cards = document.querySelectorAll('.category-card-item');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                cards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    if (name.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>

<?= view('frontend/layouts/footer', ['site_name' => $site_name]) ?>
