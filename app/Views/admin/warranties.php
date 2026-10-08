<?= $this->extend('admin/layouts/app') ?>

<?= $this->section('content') ?>
<style>
    .warranties-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
    .stat-box {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .custom-table th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 16px;
    }
    .custom-table td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .modal-style .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }
    .modal-style .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 24px;
    }
    .modal-style .modal-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 18px;
    }
    .modal-style .modal-body {
        padding: 24px;
    }
    .modal-style .form-group label {
        font-weight: 600;
        color: #1e293b;
        font-size: 13px;
        margin-bottom: 6px;
    }
    .modal-style .form-control, .modal-style select.form-control {
        width: 100% !important;
        max-width: 100% !important;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 14px;
        color: #1e293b;
        box-shadow: none !important;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out;
        height: auto;
    }
    .modal-style select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        padding-right: 40px;
    }
    .modal-style .form-control:focus {
        border-color: #3b82f6;
    }
    .modal-style .modal-footer {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 16px 24px;
    }
</style>

<div class="aiz-titlebar text-left mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 font-weight-bold text-dark mb-1">Product Warranties</h1>
            <p class="text-muted fs-13 mb-0">Manage customer warranty policies, durations, and terms efficiently.</p>
        </div>
        <div class="col-md-6 text-md-right mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm rounded-pill d-inline-flex align-items-center" data-toggle="modal" data-target="#addWarrantyModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                <i class="las la-plus fs-16 mr-2"></i>
                <span>Add New Warranty</span>
            </button>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="las la-check-circle fs-20 mr-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="las la-exclamation-triangle fs-20 mr-2"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Overview Stats -->
<?php 
    $totalCount = count($warranties ?? []);
    $activeCount = count(array_filter($warranties ?? [], fn($w) => ($w['status'] ?? 1) == 1));
    $inactiveCount = $totalCount - $activeCount;
?>
<div class="row gutters-10 mb-4">
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-primary text-primary mr-3">
                <i class="las la-shield-alt"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Total Warranties</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $totalCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-success text-success mr-3">
                <i class="las la-check-circle"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Active Policies</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $activeCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-secondary text-secondary mr-3">
                <i class="las la-pause-circle"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Disabled Policies</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $inactiveCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-warning text-warning mr-3">
                <i class="las la-clock"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Coverage Plans</div>
                <div class="fs-22 font-weight-bold text-dark">Standard</div>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="warranties-card">
    <div class="card-header border-bottom border-light py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
        <h5 class="mb-0 font-weight-bold text-dark fs-16">Warranty List</h5>
        <div class="position-relative mt-2 mt-md-0" style="width: 280px; max-width: 100%;">
            <input type="text" id="warrantySearch" class="form-control form-control-sm rounded-pill pl-4 pr-3 py-2 bg-light border-0 fs-13" placeholder="Search warranty policy...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table custom-table mb-0" id="warrantiesTable">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 220px;">Warranty Name</th>
                    <th style="width: 140px;">Duration</th>
                    <th style="min-width: 200px;">Description</th>
                    <th class="text-center" style="width: 110px;">Status</th>
                    <th class="text-right" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($warranties)): ?>
                    <?php foreach ($warranties as $index => $item): ?>
                        <?php 
                            $nameVal = esc($item['name'] ?? $item['text'] ?? 'Warranty Policy');
                            $durVal = esc($item['duration'] ?? '');
                            $unitVal = !empty($item['period_type']) ? ucfirst(esc($item['period_type'])) : '';
                        ?>
                        <tr>
                            <td class="font-weight-bold text-muted"><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="size-35px bg-soft-primary text-primary rounded d-flex align-items-center justify-content-center mr-2 font-weight-bold">
                                        <i class="las la-certificate fs-18"></i>
                                    </div>
                                    <span class="font-weight-semibold text-dark fs-14"><?= $nameVal ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-inline bg-soft-info text-info font-weight-bold px-3 py-1 fs-12">
                                    <?= trim("$durVal $unitVal") ?: $durVal ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-muted fs-13">
                                    <?= !empty($item['description']) ? esc($item['description']) : '<em class="opacity-50">No description provided</em>' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if (($item['status'] ?? 1) == 1): ?>
                                    <span class="badge badge-inline bg-soft-success text-success font-weight-bold px-3 py-1 fs-12">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-inline bg-soft-secondary text-secondary font-weight-bold px-3 py-1 fs-12">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" 
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm mr-1 edit-btn"
                                            data-id="<?= esc($item['id'] ?? '') ?>"
                                            data-name="<?= $nameVal ?>"
                                            data-duration="<?= $durVal ?>"
                                            data-period_type="<?= esc($item['period_type'] ?? 'months') ?>"
                                            data-description="<?= esc($item['description'] ?? '') ?>"
                                            data-status="<?= esc($item['status'] ?? 1) ?>"
                                            title="Edit Warranty">
                                        <i class="las la-pen"></i>
                                    </button>
                                    <a href="<?= base_url('admin/warranties/delete/' . ($item['id'] ?? 0)) ?>" 
                                       class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this warranty policy?');"
                                       title="Delete Warranty">
                                        <i class="las la-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="las la-shield-alt fs-40 text-muted opacity-50 d-block mb-2"></i>
                                <h6 class="text-secondary font-weight-bold">No Warranty Policies Found</h6>
                                <p class="text-muted fs-13 mb-3">Create your first product warranty plan to get started.</p>
                                <button class="btn btn-sm btn-primary rounded-pill px-4" data-toggle="modal" data-target="#addWarrantyModal">
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

<!-- Add Warranty Modal -->
<div class="modal fade modal-style" id="addWarrantyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Warranty Policy</h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/warranties/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. 1 Year Brand Warranty" required>
                    </div>
                    <div class="row gutters-10 mb-3">
                        <div class="col-7">
                            <div class="form-group mb-0">
                                <label>Duration Value <span class="text-danger">*</span></label>
                                <input type="number" name="duration" min="1" class="form-control" placeholder="e.g. 12" required>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group mb-0">
                                <label>Period Unit</label>
                                <select name="period_type" class="form-control">
                                    <option value="days">Days</option>
                                    <option value="months" selected>Months</option>
                                    <option value="years">Years</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description / Conditions</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Specify terms, coverage scope, or claim requirements..."></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="aiz-switch aiz-switch-success mb-0 d-flex align-items-center">
                            <input type="checkbox" name="status" value="1" checked>
                            <span class="slider round mr-2"></span>
                            <span class="fs-13 font-weight-semibold text-dark">Active Policy</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">Save Warranty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Warranty Modal -->
<div class="modal fade modal-style" id="editWarrantyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Warranty Policy</h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/warranties/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Warranty Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="row gutters-10 mb-3">
                        <div class="col-7">
                            <div class="form-group mb-0">
                                <label>Duration Value <span class="text-danger">*</span></label>
                                <input type="number" name="duration" id="edit_duration" min="1" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group mb-0">
                                <label>Period Unit</label>
                                <select name="period_type" id="edit_period_type" class="form-control">
                                    <option value="days">Days</option>
                                    <option value="months">Months</option>
                                    <option value="years">Years</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description / Conditions</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="aiz-switch aiz-switch-success mb-0 d-flex align-items-center">
                            <input type="checkbox" name="status" value="1" id="edit_status">
                            <span class="slider round mr-2"></span>
                            <span class="fs-13 font-weight-semibold text-dark">Active Policy</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">Update Warranty</button>
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

    // Edit Modal populate
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const duration = $(this).data('duration');
        const periodType = $(this).data('period_type');
        const description = $(this).data('description');
        const status = $(this).data('status');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_duration').val(duration);
        $('#edit_period_type').val(periodType || 'months');
        $('#edit_description').val(description);
        $('#edit_status').prop('checked', parseInt(status) === 1);

        $('#editWarrantyModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>
