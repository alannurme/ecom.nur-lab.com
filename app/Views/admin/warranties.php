<?= $this->extend('admin/layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Header & Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Product Warranties</h3>
            <p class="text-muted small mb-0">Manage customer warranty policies, durations, and terms efficiently.</p>
        </div>
        <div>
            <button class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm fw-medium" data-bs-toggle="modal" data-bs-target="#addWarrantyModal">
                <i class="bi bi-plus-lg fs-6"></i>
                <span>Add New Warranty</span>
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
            <div><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Overview Stats -->
    <div class="row g-3 mb-4">
        <?php 
            $totalCount = count($warranties ?? []);
            $activeCount = count(array_filter($warranties ?? [], fn($w) => ($w['status'] ?? 1) == 1));
            $inactiveCount = $totalCount - $activeCount;
        ?>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Warranties</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $totalCount ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Active Policies</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $activeCount ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-pause-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Disabled Policies</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $inactiveCount ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Coverage Types</div>
                        <div class="fs-4 fw-bold text-dark mb-0">Standard</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="fw-bold text-dark mb-0">Warranty List</h5>
            <div class="position-relative" style="max-width: 280px; width: 100%;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="warrantySearch" class="form-control ps-5 rounded-pill bg-light border-0 py-2 fs-6" placeholder="Search warranty...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="warrantiesTable">
                <thead class="bg-light border-top border-bottom text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase fs-7 fw-semibold" style="width: 70px;">#</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Warranty Name</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Duration</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Description</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold text-center">Status</th>
                        <th class="pe-4 py-3 text-uppercase fs-7 fw-semibold text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (!empty($warranties)): ?>
                        <?php foreach ($warranties as $index => $item): ?>
                            <tr>
                                <td class="ps-4 fw-medium text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 bg-primary-subtle text-primary p-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                            <i class="bi bi-patch-check"></i>
                                        </div>
                                        <span class="fw-semibold text-dark"><?= esc($item['name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $typeBadge = 'bg-info-subtle text-info';
                                        if (($item['period_type'] ?? '') === 'years') {
                                            $typeBadge = 'bg-primary-subtle text-primary';
                                        } elseif (($item['period_type'] ?? '') === 'months') {
                                            $typeBadge = 'bg-purple-subtle text-purple';
                                        }
                                    ?>
                                    <span class="badge rounded-pill px-3 py-2 <?= $typeBadge ?> fw-semibold">
                                        <?= esc($item['duration']) ?> <?= ucfirst(esc($item['period_type'] ?? 'months')) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <?= !empty($item['description']) ? esc($item['description']) : '<em class="opacity-50">No description provided</em>' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if (($item['status'] ?? 1) == 1): ?>
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-1 fw-medium">Active</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-1 fw-medium">Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-light rounded-circle edit-btn"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= esc($item['name']) ?>"
                                                data-duration="<?= esc($item['duration']) ?>"
                                                data-period_type="<?= esc($item['period_type'] ?? 'months') ?>"
                                                data-description="<?= esc($item['description'] ?? '') ?>"
                                                data-status="<?= $item['status'] ?? 1 ?>"
                                                title="Edit Warranty">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <a href="<?= base_url('admin/warranties/delete/' . $item['id']) ?>" 
                                           class="btn btn-sm btn-icon btn-light rounded-circle"
                                           onclick="return confirm('Are you sure you want to delete this warranty policy?');"
                                           title="Delete Warranty">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-shield-slash fs-1 text-muted opacity-50 d-block mb-2"></i>
                                    <h6 class="text-secondary fw-semibold">No Warranty Policies Found</h6>
                                    <p class="text-muted small mb-3">Create your first product warranty plan to get started.</p>
                                    <button class="btn btn-sm btn-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addWarrantyModal">
                                        Add Warranty
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Warranty Modal -->
<div class="modal fade" id="addWarrantyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">Add New Warranty Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/warranties/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 py-2" placeholder="e.g. 1 Year Brand Warranty" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-7">
                            <label class="form-label fw-semibold text-dark">Duration <span class="text-danger">*</span></label>
                            <input type="number" name="duration" min="1" class="form-control rounded-3 py-2" placeholder="e.g. 12" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-semibold text-dark">Period Unit</label>
                            <select name="period_type" class="form-select rounded-3 py-2">
                                <option value="days">Days</option>
                                <option value="months" selected>Months</option>
                                <option value="years">Years</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Description / Conditions</label>
                        <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Specify terms, coverage scope, or claim requirements..."></textarea>
                    </div>
                    <div class="form-check form-switch pt-1">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="addStatus" checked>
                        <label class="form-check-label fw-medium text-dark" for="addStatus">Active Policy</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">Save Warranty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Warranty Modal -->
<div class="modal fade" id="editWarrantyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">Edit Warranty Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/warranties/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control rounded-3 py-2" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-7">
                            <label class="form-label fw-semibold text-dark">Duration <span class="text-danger">*</span></label>
                            <input type="number" name="duration" id="edit_duration" min="1" class="form-control rounded-3 py-2" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-semibold text-dark">Period Unit</label>
                            <select name="period_type" id="edit_period_type" class="form-select rounded-3 py-2">
                                <option value="days">Days</option>
                                <option value="months">Months</option>
                                <option value="years">Years</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Description / Conditions</label>
                        <textarea name="description" id="edit_description" class="form-control rounded-3" rows="3"></textarea>
                    </div>
                    <div class="form-check form-switch pt-1">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="edit_status">
                        <label class="form-check-label fw-medium text-dark" for="edit_status">Active Policy</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">Update Warranty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live Search
    const searchInput = document.getElementById('warrantySearch');
    const tableRows = document.querySelectorAll('#warrantiesTable tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // Edit Modal Trigger
    const editBtns = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editWarrantyModal'));

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_duration').value = this.dataset.duration;
            document.getElementById('edit_period_type').value = this.dataset.period_type;
            document.getElementById('edit_description').value = this.dataset.description;
            document.getElementById('edit_status').checked = (this.dataset.status == 1);
            
            editModal.show();
        });
    });
});
</script>
<?= $this->endSection() ?>
