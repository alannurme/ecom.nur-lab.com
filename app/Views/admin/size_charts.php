<?= $this->include('admin/layouts/header') ?>

<style>
    .chart-stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .chart-stat-card:hover {
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
    .stat-icon.rose { background: linear-gradient(135deg, rgba(244, 63, 94, 0.15), rgba(251, 113, 133, 0.05)); color: #f43f5e; }
    .stat-icon.success { background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(74, 222, 128, 0.05)); color: #16a34a; }
    .stat-icon.indigo { background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05)); color: #6366f1; }

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

    .size-chip {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        margin-right: 4px;
        margin-bottom: 4px;
    }
</style>

<!-- Titlebar -->
<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); color: white; box-shadow: 0 6px 18px rgba(244, 63, 94, 0.3);">
                <i class="las la-ruler-horizontal fs-26"></i>
            </div>
            <div>
                <h1 class="h3 fw-800 mb-1" style="color: #0f172a;">Product Size Charts</h1>
                <span class="fs-14 text-muted">Create, edit, and assign apparel and footwear measurement size charts to product categories.</span>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2.5 fw-700 shadow-sm" data-toggle="modal" data-target="#addChartModal" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); border: none;">
                <i class="las la-plus mr-1"></i> Add New Size Chart
            </button>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Stat Summary Row -->
    <?php $totalCharts = count($charts ?? []); ?>
    <div class="row gutters-15 mb-4">
        <div class="col-md-4 mb-3">
            <div class="chart-stat-card d-flex align-items-center">
                <div class="stat-icon rose mr-3">
                    <i class="las la-ruler-combined"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0f172a;"><?= $totalCharts ?></h4>
                    <span class="fs-12 text-muted fw-600">Total Size Charts</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="chart-stat-card d-flex align-items-center">
                <div class="stat-icon success mr-3">
                    <i class="las la-tags"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #16a34a;"><?= $totalCharts ?></h4>
                    <span class="fs-12 text-muted fw-600">Covered Categories</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="chart-stat-card d-flex align-items-center">
                <div class="stat-icon indigo mr-3">
                    <i class="las la-tshirt"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #6366f1;">Active Presets</h4>
                    <span class="fs-12 text-muted fw-600">S, M, L, XL, XXL Sizes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Directory Table Card -->
    <div class="card premium-card">
        <div class="premium-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <i class="las la-list fs-20 text-rose mr-2" style="color: #f43f5e;"></i>
                <h5 class="mb-0 fw-700 fs-16 text-dark">Size Charts Directory</h5>
            </div>
            <div class="search-box" style="width: 240px;">
                <input type="text" id="chartSearchInput" class="form-control form-control-sm rounded-pill" placeholder="Search size charts...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle" id="chartsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 pl-4" style="width: 70px;">#</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Chart Name & Details</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Category Name</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Supported Sizes</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-right pr-4">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($charts)): ?>
                            <?php foreach ($charts as $index => $c): ?>
                                <tr class="chart-row">
                                    <td class="pl-4 fw-700 text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center py-1">
                                            <div class="p-2 rounded-circle bg-light mr-3 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; color: #f43f5e !important;">
                                                <i class="las la-ruler-horizontal fs-18"></i>
                                            </div>
                                            <span class="fw-700 text-dark fs-14 chart-name"><?= esc($c['name']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-weight-bold px-2.5 py-1" style="font-size: 11px;">
                                            <i class="las la-folder text-muted mr-1"></i> <?= esc($c['category']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="py-1">
                                            <?php 
                                            $sizeList = explode(',', $c['sizes'] ?? '');
                                            foreach ($sizeList as $sz):
                                                $sz = trim($sz);
                                                if (!empty($sz)):
                                            ?>
                                                <span class="size-chip"><?= esc($sz) ?></span>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <button type="button" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" 
                                                onclick="openEditChartModal(<?= htmlspecialchars(json_encode($c)) ?>)" title="Edit Size Chart">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/size-charts/delete/' . $c['id']) ?>" 
                                           onclick="return confirm('Are you sure you want to delete this size chart?');" 
                                           class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete Size Chart">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No size charts found. Click "Add New Size Chart" to create one.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Chart Modal -->
<div class="modal fade" id="addChartModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-ruler-horizontal text-rose mr-1" style="color:#f43f5e;"></i> Add New Size Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/size-charts/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Size Chart Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Men T-Shirt Size Chart" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Category <span class="text-danger">*</span></label>
                        <select class="form-control aiz-selectpicker" name="category" data-live-search="true" required>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['name']) ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="Men Clothing">Men Clothing</option>
                                <option value="Women Clothing">Women Clothing</option>
                                <option value="Kids Apparel">Kids Apparel</option>
                                <option value="Shoes & Footwear">Shoes & Footwear</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Supported Sizes <span class="text-danger">*</span></label>
                        <input type="text" name="sizes" class="form-control" value="S, M, L, XL, XXL" placeholder="e.g. S, M, L, XL, XXL" required>
                        <small class="form-text text-muted mt-2">Enter available sizes separated by commas.</small>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); border: none;">Save Size Chart</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Chart Modal -->
<div class="modal fade" id="editChartModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-edit text-rose mr-1" style="color:#f43f5e;"></i> Edit Size Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/size-charts/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_chart_id">
                
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Size Chart Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_chart_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="edit_chart_category" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Supported Sizes <span class="text-danger">*</span></label>
                        <input type="text" name="sizes" id="edit_chart_sizes" class="form-control" required>
                        <small class="form-text text-muted mt-2">Enter available sizes separated by commas.</small>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); border: none;">Update Size Chart</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('chartSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#chartsTable .chart-row');
            rows.forEach(row => {
                const text = row.querySelector('.chart-name').innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

function openEditChartModal(chart) {
    document.getElementById('edit_chart_id').value = chart.id;
    document.getElementById('edit_chart_name').value = chart.name;
    document.getElementById('edit_chart_category').value = chart.category || 'General';
    document.getElementById('edit_chart_sizes').value = chart.sizes || 'S, M, L, XL';
    
    $('#editChartModal').modal('show');
}
</script>

<?= $this->include('admin/layouts/footer') ?>
