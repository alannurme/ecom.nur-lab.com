<?= $this->include('admin/layouts/header') ?>

<style>
    .point-stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .point-stat-card:hover {
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
    .stat-icon.indigo { background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05)); color: #6366f1; }
    .stat-icon.success { background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(74, 222, 128, 0.05)); color: #16a34a; }
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
</style>

<!-- Titlebar -->
<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; box-shadow: 0 6px 18px rgba(99, 102, 241, 0.3);">
                <i class="las la-ruler-combined fs-26"></i>
            </div>
            <div>
                <h1 class="h3 fw-800 mb-1" style="color: #0f172a;">Measurement Points</h1>
                <span class="fs-14 text-muted">Manage standard body & apparel measurement points for size charts and custom fit guides.</span>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2.5 fw-700 shadow-sm" data-toggle="modal" data-target="#addPointModal" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none;">
                <i class="las la-plus mr-1"></i> Add Measurement Point
            </button>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Stat Summary Row -->
    <?php $totalPoints = count($points ?? []); ?>
    <div class="row gutters-15 mb-4">
        <div class="col-md-4 mb-3">
            <div class="point-stat-card d-flex align-items-center">
                <div class="stat-icon indigo mr-3">
                    <i class="las la-ruler"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0f172a;"><?= $totalPoints ?></h4>
                    <span class="fs-12 text-muted fw-600">Total Measurement Points</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="point-stat-card d-flex align-items-center">
                <div class="stat-icon success mr-3">
                    <i class="las la-check-circle"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #16a34a;"><?= $totalPoints ?></h4>
                    <span class="fs-12 text-muted fw-600">Apparel Size Specs</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="point-stat-card d-flex align-items-center">
                <div class="stat-icon info mr-3">
                    <i class="las la-tshirt"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0284c7;"><?= $totalPoints ?> Specs</h4>
                    <span class="fs-12 text-muted fw-600">Active Fit Guides</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Directory Table Card -->
    <div class="card premium-card">
        <div class="premium-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <i class="las la-list fs-20 text-indigo mr-2" style="color: #6366f1;"></i>
                <h5 class="mb-0 fw-700 fs-16 text-dark">Measurement Points Directory</h5>
            </div>
            <div class="search-box" style="width: 240px;">
                <input type="text" id="pointSearchInput" class="form-control form-control-sm rounded-pill" placeholder="Search points...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle" id="pointsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 pl-4" style="width: 70px;">#</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Measurement Point Name</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Reference Code</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Measurement Unit</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-right pr-4">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($points)): ?>
                            <?php foreach ($points as $index => $p): ?>
                                <tr class="point-row">
                                    <td class="pl-4 fw-700 text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center py-1">
                                            <div class="p-2 rounded-circle bg-light mr-3 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="las la-ruler-vertical fs-18"></i>
                                            </div>
                                            <span class="fw-700 text-dark fs-14 point-name"><?= esc($p['name']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-weight-bold px-2.5 py-1" style="font-size: 11px;">
                                            <?= esc($p['code'] ?? 'REF') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-13 font-weight-normal">
                                            <i class="las la-tape mr-1"></i> <?= esc($p['unit'] ?? 'inches / cm') ?>
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <button type="button" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" 
                                                onclick="openEditPointModal(<?= htmlspecialchars(json_encode($p)) ?>)" title="Edit Point">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/measurement-points/delete/' . $p['id']) ?>" 
                                           onclick="return confirm('Are you sure you want to delete this measurement point?');" 
                                           class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete Point">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No measurement points found. Click "Add Measurement Point" to create one.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Point Modal -->
<div class="modal fade" id="addPointModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-ruler-combined text-primary mr-1"></i> Add Measurement Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/measurement-points/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Measurement Point Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Chest / Bust, Waist, Hips" required>
                    </div>
                    <div class="row gutters-10 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Reference Code</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g. CHEST">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Unit</label>
                            <input type="text" name="unit" class="form-control" value="inches / cm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none;">Save Point</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Point Modal -->
<div class="modal fade" id="editPointModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-edit text-primary mr-1"></i> Edit Measurement Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/measurement-points/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_point_id">
                
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Measurement Point Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_point_name" class="form-control" required>
                    </div>
                    <div class="row gutters-10 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Reference Code</label>
                            <input type="text" name="code" id="edit_point_code" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Unit</label>
                            <input type="text" name="unit" id="edit_point_unit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none;">Update Point</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pointSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#pointsTable .point-row');
            rows.forEach(row => {
                const text = row.querySelector('.point-name').innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

function openEditPointModal(point) {
    document.getElementById('edit_point_id').value = point.id;
    document.getElementById('edit_point_name').value = point.name;
    document.getElementById('edit_point_code').value = point.code || '';
    document.getElementById('edit_point_unit').value = point.unit || 'inches / cm';
    
    $('#editPointModal').modal('show');
}
</script>

<?= $this->include('admin/layouts/footer') ?>
