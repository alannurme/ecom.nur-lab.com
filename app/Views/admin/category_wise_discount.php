<?= $this->include('admin/layouts/header') ?>

<style>
    .discount-stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .discount-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .stat-icon.emerald { background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(16, 185, 129, 0.05)); color: #059669; }
    .stat-icon.primary { background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(99, 102, 241, 0.05)); color: #4f46e5; }
    .stat-icon.warning { background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.05)); color: #d97706; }
    .stat-icon.info { background: linear-gradient(135deg, rgba(14, 165, 233, 0.15), rgba(56, 189, 248, 0.05)); color: #0284c7; }

    .premium-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .premium-card-header {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .discount-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .discount-pill.percent { background: #dcfce7; color: #15803d; }
    .discount-pill.flat { background: #e0f2fe; color: #0369a1; }
    .discount-pill.none { background: #f1f5f9; color: #64748b; }
</style>

<!-- Titlebar -->
<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; box-shadow: 0 6px 18px rgba(5, 150, 105, 0.3);">
                <i class="las la-percent fs-26"></i>
            </div>
            <div>
                <h1 class="h3 fw-800 mb-1" style="color: #0f172a;">Category-Wise Discount Setup</h1>
                <span class="fs-14 text-muted">Apply bulk promotional discounts and special offers across product categories.</span>
            </div>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Stat Summary Cards -->
    <?php
    $totalCategories = count($categories ?? []);
    $discountedCount = 0;
    $flatCount = 0;
    $percentCount = 0;
    if (!empty($category_discount_rules) && is_array($category_discount_rules)) {
        foreach ($category_discount_rules as $rule) {
            if (!empty($rule['discount']) && $rule['discount'] > 0) {
                $discountedCount++;
                if (($rule['discount_type'] ?? '') === 'percent') {
                    $percentCount++;
                } else {
                    $flatCount++;
                }
            }
        }
    }
    ?>
    <div class="row gutters-15 mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="discount-stat-card d-flex align-items-center">
                <div class="stat-icon primary mr-3">
                    <i class="las la-tags"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0f172a;"><?= $totalCategories ?></h4>
                    <span class="fs-12 text-muted fw-600">Total Categories</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="discount-stat-card d-flex align-items-center">
                <div class="stat-icon emerald mr-3">
                    <i class="las la-percentage"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #059669;"><?= $discountedCount ?></h4>
                    <span class="fs-12 text-muted fw-600">Active Discounts</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="discount-stat-card d-flex align-items-center">
                <div class="stat-icon info mr-3">
                    <i class="las la-bolt"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0284c7;"><?= $percentCount ?></h4>
                    <span class="fs-12 text-muted fw-600">Percent (%) OFF</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="discount-stat-card d-flex align-items-center">
                <div class="stat-icon warning mr-3">
                    <i class="las la-money-bill-wave"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #d97706;"><?= $flatCount ?></h4>
                    <span class="fs-12 text-muted fw-600">Flat Amount OFF</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row gutters-15">
        <!-- Configuration Form Column -->
        <div class="col-lg-5 mb-4">
            <div class="card premium-card h-100">
                <div class="premium-card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="las la-tags fs-20 text-emerald mr-2" style="color: #059669;"></i>
                        <h5 class="mb-0 fw-700 fs-16 text-dark">Set Category Discount</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('admin/category-wise-discount/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <!-- Select Categories -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-700 text-dark fs-13">
                                Select Categories <span class="text-danger">*</span>
                            </label>
                            <select class="form-control aiz-selectpicker" name="category_ids[]" id="discount_category_select" multiple data-live-search="true" data-selected-text-format="count > 2" title="Choose categories..." required>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-text text-muted mt-2">
                                <i class="las la-info-circle"></i> Select single or multiple categories to bulk apply product discounts.
                            </small>
                        </div>

                        <!-- Discount Amount -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-700 text-dark fs-13">Discount Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="las la-tag fs-18"></i></span>
                                </div>
                                <input type="number" step="0.01" min="0" class="form-control border-left-0 pl-0" name="discount" placeholder="e.g. 15 or 100" required>
                            </div>
                        </div>

                        <!-- Discount Type -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-700 text-dark fs-13">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-control aiz-selectpicker" name="discount_type" required>
                                <option value="flat">Flat Amount (৳)</option>
                                <option value="percent">Percentage (%)</option>
                            </select>
                        </div>

                        <div class="p-3 bg-light rounded-2 border mb-4">
                            <small class="text-muted d-block fs-12">
                                <i class="las la-exclamation-circle text-warning mr-1"></i>
                                Applying a category-wise discount will immediately update the discount on all products under the selected categories.
                            </small>
                        </div>

                        <div class="pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2.5 fw-700 shadow-sm" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none;">
                                <i class="las la-bolt mr-1"></i> Apply Category Discount
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Directory Table Column -->
        <div class="col-lg-7 mb-4">
            <div class="card premium-card h-100">
                <div class="premium-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <i class="las la-list fs-20 text-emerald mr-2" style="color: #059669;"></i>
                        <h5 class="mb-0 fw-700 fs-16 text-dark">Category Discount Directory</h5>
                    </div>
                    <div class="search-box" style="width: 220px;">
                        <input type="text" id="discountCategorySearch" class="form-control form-control-sm rounded-pill" placeholder="Search category...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table aiz-table mb-0 align-middle" id="discountTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 pl-4">Category</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-center">Discount Rule</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-center">Type</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-right pr-4">Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $index => $cat): ?>
                                        <?php 
                                        $catId = $cat['id'];
                                        $rule = $category_discount_rules[$catId] ?? null;
                                        $discountVal = $rule['discount'] ?? 0;
                                        $discountType = $rule['discount_type'] ?? 'flat';
                                        $updatedAt = $rule['updated_at'] ?? '-';
                                        ?>
                                        <tr class="cat-row">
                                            <td class="pl-4">
                                                <div class="d-flex align-items-center py-1">
                                                    <div class="mr-3 p-2 rounded bg-light flex-shrink-0" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                        <?php if (!empty($cat['icon_img'])): ?>
                                                            <img src="<?= base_url($cat['icon_img']) ?>" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                        <?php else: ?>
                                                            <i class="las la-folder text-emerald fs-20" style="color: #059669;"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <span class="fw-700 text-dark fs-14 cat-name"><?= esc($cat['name']) ?></span>
                                                        <small class="text-muted d-block fs-11">ID: #<?= $cat['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($discountVal > 0): ?>
                                                    <span class="discount-pill <?= $discountType === 'percent' ? 'percent' : 'flat' ?>">
                                                        <i class="las <?= $discountType === 'percent' ? 'la-percentage' : 'la-tag' ?>"></i> 
                                                        <?= $discountType === 'percent' ? (int)$discountVal . '% OFF' : '৳' . number_format($discountVal, 2) . ' OFF' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="discount-pill none">
                                                        <i class="las la-minus"></i> No Discount
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center fw-600 text-muted fs-13">
                                                <?= $discountVal > 0 ? ucfirst($discountType) : '-' ?>
                                            </td>
                                            <td class="text-right pr-4 fs-12 text-muted">
                                                <?= esc($updatedAt) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No categories found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('discountCategorySearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#discountTable .cat-row');
            rows.forEach(row => {
                const text = row.querySelector('.cat-name').innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?= $this->include('admin/layouts/footer') ?>
