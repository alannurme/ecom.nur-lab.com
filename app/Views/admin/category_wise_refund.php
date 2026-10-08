<?= $this->include('admin/layouts/header') ?>

<style>
    .refund-stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .refund-stat-card:hover {
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
    .stat-icon.primary { background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(99, 102, 241, 0.05)); color: #4f46e5; }
    .stat-icon.success { background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(74, 222, 128, 0.05)); color: #16a34a; }
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

    .status-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .status-pill.active { background: #dcfce7; color: #15803d; }
    .status-pill.disabled { background: #f1f5f9; color: #64748b; }
</style>

<!-- Titlebar -->
<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; box-shadow: 0 6px 18px rgba(79, 70, 229, 0.3);">
                <i class="las la-undo-alt fs-26"></i>
            </div>
            <div>
                <h1 class="h3 fw-800 mb-1" style="color: #0f172a;">Category-Wise Refund Setup</h1>
                <span class="fs-14 text-muted">Configure refund eligibility and guarantee timeframes for product categories.</span>
            </div>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Stat Summary Cards -->
    <?php
    $totalCategories = count($categories ?? []);
    $refundableCount = 0;
    if (!empty($category_refund_rules) && is_array($category_refund_rules)) {
        foreach ($category_refund_rules as $rule) {
            if (!empty($rule['refundable']) && $rule['refundable'] == 1) {
                $refundableCount++;
            }
        }
    } else {
        $refundableCount = $totalCategories; // default all refundable
    }
    $nonRefundableCount = max(0, $totalCategories - $refundableCount);
    ?>
    <div class="row gutters-15 mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="refund-stat-card d-flex align-items-center">
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
            <div class="refund-stat-card d-flex align-items-center">
                <div class="stat-icon success mr-3">
                    <i class="las la-check-circle"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #16a34a;"><?= $refundableCount ?></h4>
                    <span class="fs-12 text-muted fw-600">Refund Enabled</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="refund-stat-card d-flex align-items-center">
                <div class="stat-icon warning mr-3">
                    <i class="las la-ban"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #d97706;"><?= $nonRefundableCount ?></h4>
                    <span class="fs-12 text-muted fw-600">Refund Disabled</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="refund-stat-card d-flex align-items-center">
                <div class="stat-icon info mr-3">
                    <i class="las la-clock"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0284c7;"><?= esc($category_refund_days ?? 7) ?> Days</h4>
                    <span class="fs-12 text-muted fw-600">Default Policy Window</span>
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
                        <i class="las la-sliders-h fs-20 text-primary mr-2"></i>
                        <h5 class="mb-0 fw-700 fs-16 text-dark">Configure Category Rules</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('admin/category-wise-refund/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <!-- Select Categories -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-700 text-dark fs-13">
                                Select Categories <span class="text-danger">*</span>
                            </label>
                            <select class="form-control aiz-selectpicker" name="category_ids[]" id="category_select" multiple data-live-search="true" data-selected-text-format="count > 2" title="Choose categories..." required>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-text text-muted mt-2">
                                <i class="las la-info-circle"></i> You can select single or multiple categories to update refund settings.
                            </small>
                        </div>

                        <!-- Refundable Toggle -->
                        <div class="form-group mb-4 p-3 bg-light rounded-2 border">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-700 fs-14 text-dark mb-1">Allow Refund Status</h6>
                                    <span class="fs-12 text-muted">Enable or disable product return requests for selected categories.</span>
                                </div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="refundable" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Refund Days Limit -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-700 text-dark fs-13">Refund Window (Days)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="las la-calendar-check fs-18"></i></span>
                                </div>
                                <input type="number" name="refund_days" class="form-control border-left-0 pl-0" value="<?= esc($category_refund_days ?? 7) ?>" min="1" max="90" placeholder="e.g. 7" required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-light border-left-0 fw-600">Days</span>
                                </div>
                            </div>
                            <small class="form-text text-muted mt-2">Number of days customers can initiate a return after order delivery.</small>
                        </div>

                        <div class="pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2.5 fw-700 shadow-sm" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none;">
                                <i class="las la-save mr-1"></i> Save Configuration
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
                        <i class="las la-list fs-20 text-primary mr-2"></i>
                        <h5 class="mb-0 fw-700 fs-16 text-dark">Category Status Directory</h5>
                    </div>
                    <div class="search-box" style="width: 220px;">
                        <input type="text" id="categorySearch" class="form-control form-control-sm rounded-pill" placeholder="Search category...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table aiz-table mb-0 align-middle" id="refundTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 pl-4">Category</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-center">Refund Policy</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-center">Time Limit</th>
                                    <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-right pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $index => $cat): ?>
                                        <?php 
                                        $catId = $cat['id'];
                                        $rule = $category_refund_rules[$catId] ?? null;
                                        $isRefundable = isset($rule['refundable']) ? $rule['refundable'] == 1 : true;
                                        $days = $rule['refund_days'] ?? ($category_refund_days ?? 7);
                                        ?>
                                        <tr class="cat-row">
                                            <td class="pl-4">
                                                <div class="d-flex align-items-center py-1">
                                                    <div class="mr-3 p-2 rounded bg-light flex-shrink-0" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                        <?php if (!empty($cat['icon_img'])): ?>
                                                            <img src="<?= base_url($cat['icon_img']) ?>" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                        <?php else: ?>
                                                            <i class="las la-folder text-primary fs-20"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <span class="fw-700 text-dark fs-14 cat-name"><?= esc($cat['name']) ?></span>
                                                        <small class="text-muted d-block fs-11">ID: #<?= $cat['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($isRefundable): ?>
                                                    <span class="status-pill active">
                                                        <i class="las la-check-circle"></i> Refund Allowed
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-pill disabled">
                                                        <i class="las la-times-circle"></i> Non-Refundable
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center fw-700 text-dark fs-13">
                                                <?= $isRefundable ? $days . ' Days' : '-' ?>
                                            </td>
                                            <td class="text-right pr-4">
                                                <label class="aiz-switch aiz-switch-success mb-0" data-toggle="tooltip" title="Quick toggle category refund">
                                                    <input type="checkbox" onchange="quickToggleCategoryRefund(<?= $cat['id'] ?>, this.checked)" <?= $isRefundable ? 'checked' : '' ?>>
                                                    <span class="slider round"></span>
                                                </label>
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
    const searchInput = document.getElementById('categorySearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#refundTable .cat-row');
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

function quickToggleCategoryRefund(categoryId, status) {
    $.ajax({
        url: '<?= base_url('admin/category-wise-refund/update') ?>',
        type: 'POST',
        data: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            'category_ids[]': categoryId,
            'refundable': status ? 1 : 0,
            'refund_days': 7
        },
        success: function(response) {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('success', 'Refund policy updated for category.');
            }
        },
        error: function() {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Error updating category refund status.');
            }
        }
    });
}
</script>

<?= $this->include('admin/layouts/footer') ?>
