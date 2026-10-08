<?= $this->extend('admin/layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Header & Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Product Units</h3>
            <p class="text-muted small mb-0">Manage measurement units (e.g. Pc, KG, Litre) for your store catalog.</p>
        </div>
        <div>
            <button class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm fw-medium" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                <i class="bi bi-plus-lg fs-6"></i>
                <span>Add New Unit</span>
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
            $totalUnits = count($units ?? []);
            $activeUnits = count(array_filter($units ?? [], fn($u) => ($u['status'] ?? 1) == 1));
            $disabledUnits = $totalUnits - $activeUnits;
        ?>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Units</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $totalUnits ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Active Units</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $activeUnits ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-pause-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Disabled Units</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $disabledUnits ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="fw-bold text-dark mb-0">Measurement Units List</h5>
            <div class="position-relative" style="max-width: 280px; width: 100%;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="unitSearch" class="form-control ps-5 rounded-pill bg-light border-0 py-2 fs-6" placeholder="Search unit...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="unitsTable">
                <thead class="bg-light border-top border-bottom text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase fs-7 fw-semibold" style="width: 70px;">#</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Unit Name</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Unit Code / Symbol</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold text-center">Status</th>
                        <th class="pe-4 py-3 text-uppercase fs-7 fw-semibold text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (!empty($units)): ?>
                        <?php foreach ($units as $index => $item): ?>
                            <tr>
                                <td class="ps-4 fw-medium text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 bg-primary-subtle text-primary p-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                            <i class="bi bi-rulers"></i>
                                        </div>
                                        <span class="fw-bold text-dark"><?= esc($item['name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2 font-monospace fw-semibold">
                                        <?= esc($item['code'] ?? strtolower($item['name'])) ?>
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
                                                data-code="<?= esc($item['code'] ?? '') ?>"
                                                data-status="<?= $item['status'] ?? 1 ?>"
                                                title="Edit Unit">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <a href="<?= base_url('admin/units/delete/' . $item['id']) ?>" 
                                           class="btn btn-sm btn-icon btn-light rounded-circle"
                                           onclick="return confirm('Are you sure you want to delete this unit?');"
                                           title="Delete Unit">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-rulers fs-1 text-muted opacity-50 d-block mb-2"></i>
                                    <h6 class="text-secondary fw-semibold">No Units Found</h6>
                                    <p class="text-muted small mb-3">Create your first measurement unit (e.g. Kg, Pc, Litre) to assign to products.</p>
                                    <button class="btn btn-sm btn-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                                        Add Unit
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

<!-- Add Unit Modal -->
<div class="modal fade" id="addUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">Add New Measurement Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/units/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 py-2" placeholder="e.g. Kilogram, Piece, Litre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Unit Code / Symbol</label>
                        <input type="text" name="code" class="form-control rounded-3 py-2" placeholder="e.g. kg, pc, ltr (optional)">
                    </div>
                    <div class="form-check form-switch pt-1">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="addUnitStatus" checked>
                        <label class="form-check-label fw-medium text-dark" for="addUnitStatus">Active Unit</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">Save Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Unit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">Edit Measurement Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/units/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_unit_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_unit_name" class="form-control rounded-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Unit Code / Symbol</label>
                        <input type="text" name="code" id="edit_unit_code" class="form-control rounded-3 py-2">
                    </div>
                    <div class="form-check form-switch pt-1">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="edit_unit_status">
                        <label class="form-check-label fw-medium text-dark" for="edit_unit_status">Active Unit</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">Update Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live Search
    const searchInput = document.getElementById('unitSearch');
    const tableRows = document.querySelectorAll('#unitsTable tbody tr');

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
    const editModal = new bootstrap.Modal(document.getElementById('editUnitModal'));

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_unit_id').value = this.dataset.id;
            document.getElementById('edit_unit_name').value = this.dataset.name;
            document.getElementById('edit_unit_code').value = this.dataset.code;
            document.getElementById('edit_unit_status').checked = (this.dataset.status == 1);
            
            editModal.show();
        });
    });
});
</script>
<?= $this->endSection() ?>
