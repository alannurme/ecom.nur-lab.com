<?= $this->include('admin/layouts/header') ?>

<style>
    .label-stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .label-stat-card:hover {
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
    .stat-icon.sky { background: linear-gradient(135deg, rgba(2, 132, 199, 0.15), rgba(6, 182, 212, 0.05)); color: #0284c7; }
    .stat-icon.success { background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(74, 222, 128, 0.05)); color: #16a34a; }
    .stat-icon.purple { background: linear-gradient(135deg, rgba(147, 51, 234, 0.15), rgba(192, 132, 252, 0.05)); color: #9333ea; }

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

    .color-swatch-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        vertical-align: middle;
        border: 1px solid rgba(0,0,0,0.15);
    }
    .modal-preview-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
</style>

<!-- Titlebar -->
<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%); color: white; box-shadow: 0 6px 18px rgba(2, 132, 199, 0.3);">
                <i class="las la-tags fs-26"></i>
            </div>
            <div>
                <h1 class="h3 fw-800 mb-1" style="color: #0f172a;">Custom Product Labels & Badges</h1>
                <span class="fs-14 text-muted">Create, edit, and assign custom badge tags (e.g. New Arrival, Trending) to your store products.</span>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2.5 fw-700 shadow-sm" data-toggle="modal" data-target="#addLabelModal" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%); border: none;">
                <i class="las la-plus mr-1"></i> Add Custom Label
            </button>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Stat Summary Row -->
    <?php $totalLabels = count($labels ?? []); ?>
    <div class="row gutters-15 mb-4">
        <div class="col-md-4 mb-3">
            <div class="label-stat-card d-flex align-items-center">
                <div class="stat-icon sky mr-3">
                    <i class="las la-tags"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #0f172a;"><?= $totalLabels ?></h4>
                    <span class="fs-12 text-muted fw-600">Total Custom Labels</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="label-stat-card d-flex align-items-center">
                <div class="stat-icon success mr-3">
                    <i class="las la-check-circle"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #16a34a;"><?= $totalLabels ?></h4>
                    <span class="fs-12 text-muted fw-600">Active Badges</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="label-stat-card d-flex align-items-center">
                <div class="stat-icon purple mr-3">
                    <i class="las la-palette"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-0" style="color: #9333ea;"><?= $totalLabels ?> Colors</h4>
                    <span class="fs-12 text-muted fw-600">Custom Color Schemes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Labels Table Card -->
    <div class="card premium-card">
        <div class="premium-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <i class="las la-list fs-20 text-sky mr-2" style="color: #0284c7;"></i>
                <h5 class="mb-0 fw-700 fs-16 text-dark">Custom Labels Directory</h5>
            </div>
            <div class="search-box" style="width: 240px;">
                <input type="text" id="labelSearchInput" class="form-control form-control-sm rounded-pill" placeholder="Search labels...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle" id="customLabelsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 pl-4" style="width: 70px;">#</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Badge Title & Live Preview</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Text Color</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0">Background Color</th>
                            <th class="fw-700 text-dark fs-12 uppercase border-top-0 text-right pr-4">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($labels)): ?>
                            <?php foreach ($labels as $index => $lbl): ?>
                                <tr class="label-row">
                                    <td class="pl-4 fw-700 text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-inline px-3 py-2 fs-13 font-weight-bold shadow-sm label-title-text" 
                                                  style="background: <?= esc($lbl['bg_color']) ?>; color: <?= esc($lbl['text_color']) ?>; border-radius: 8px; font-size: 13px; font-weight: 700;">
                                                <?= esc($lbl['title']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center fs-13 fw-600 text-dark">
                                            <span class="color-swatch-dot mr-2" style="background: <?= esc($lbl['text_color']) ?>;"></span>
                                            <code><?= esc($lbl['text_color']) ?></code>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center fs-13 fw-600 text-dark">
                                            <span class="color-swatch-dot mr-2" style="background: <?= esc($lbl['bg_color']) ?>;"></span>
                                            <code><?= esc($lbl['bg_color']) ?></code>
                                        </div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <button type="button" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" 
                                                onclick="openEditModal(<?= htmlspecialchars(json_encode($lbl)) ?>)" title="Edit Label">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/custom-labels/delete/' . $lbl['id']) ?>" 
                                           onclick="return confirm('Are you sure you want to delete this custom label?');" 
                                           class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete Label">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No custom labels found. Click "Add Custom Label" to create one.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Custom Label Modal -->
<div class="modal fade" id="addLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-tag text-primary mr-1"></i> Add Custom Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/custom-labels/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Label Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. New Arrival, Hot Deal" required onkeyup="updateAddPreview()">
                    </div>

                    <div class="row gutters-10 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Text Color</label>
                            <div class="input-group">
                                <input type="color" id="add_text_color_picker" class="form-control p-1 mr-2" value="#ffffff" style="max-width: 42px; height: 38px; border-radius: 6px; cursor: pointer;" oninput="syncAddColor('text')">
                                <input type="text" name="text_color" id="add_text_color" class="form-control" value="#ffffff" required onkeyup="updateAddPreview()">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Background Color</label>
                            <div class="input-group">
                                <input type="color" id="add_bg_color_picker" class="form-control p-1 mr-2" value="#0099ff" style="max-width: 42px; height: 38px; border-radius: 6px; cursor: pointer;" oninput="syncAddColor('bg')">
                                <input type="text" name="bg_color" id="add_bg_color" class="form-control" value="#0099ff" required onkeyup="updateAddPreview()">
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview Box -->
                    <div class="p-3 bg-light rounded text-center border">
                        <span class="fs-12 text-muted d-block mb-2 fw-600">LIVE PREVIEW</span>
                        <span id="add_badge_preview" class="modal-preview-badge" style="background: #0099ff; color: #ffffff;">
                            New Arrival
                        </span>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%); border: none;">Save Label</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Custom Label Modal -->
<div class="modal fade" id="editLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header px-4 py-3 bg-light border-bottom">
                <h5 class="modal-title fw-700 text-dark"><i class="las la-edit text-primary mr-1"></i> Edit Custom Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/custom-labels/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_label_id">
                
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-700 text-dark fs-13">Label Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_label_title" class="form-control" required onkeyup="updateEditPreview()">
                    </div>

                    <div class="row gutters-10 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Text Color</label>
                            <div class="input-group">
                                <input type="color" id="edit_text_color_picker" class="form-control p-1 mr-2" style="max-width: 42px; height: 38px; border-radius: 6px; cursor: pointer;" oninput="syncEditColor('text')">
                                <input type="text" name="text_color" id="edit_label_text_color" class="form-control" required onkeyup="updateEditPreview()">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-700 text-dark fs-13">Background Color</label>
                            <div class="input-group">
                                <input type="color" id="edit_bg_color_picker" class="form-control p-1 mr-2" style="max-width: 42px; height: 38px; border-radius: 6px; cursor: pointer;" oninput="syncEditColor('bg')">
                                <input type="text" name="bg_color" id="edit_label_bg_color" class="form-control" required onkeyup="updateEditPreview()">
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview Box -->
                    <div class="p-3 bg-light rounded text-center border">
                        <span class="fs-12 text-muted d-block mb-2 fw-600">LIVE PREVIEW</span>
                        <span id="edit_badge_preview" class="modal-preview-badge">
                            Sample Label
                        </span>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-700 shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%); border: none;">Update Label</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('labelSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#customLabelsTable .label-row');
            rows.forEach(row => {
                const text = row.querySelector('.label-title-text').innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

function openEditModal(label) {
    document.getElementById('edit_label_id').value = label.id;
    document.getElementById('edit_label_title').value = label.title;
    document.getElementById('edit_label_text_color').value = label.text_color;
    document.getElementById('edit_text_color_picker').value = label.text_color;
    document.getElementById('edit_label_bg_color').value = label.bg_color;
    document.getElementById('edit_bg_color_picker').value = label.bg_color;
    
    updateEditPreview();
    $('#editLabelModal').modal('show');
}

function syncAddColor(type) {
    if (type === 'text') {
        document.getElementById('add_text_color').value = document.getElementById('add_text_color_picker').value;
    } else {
        document.getElementById('add_bg_color').value = document.getElementById('add_bg_color_picker').value;
    }
    updateAddPreview();
}

function updateAddPreview() {
    const title = document.getElementById('add_title').value || 'New Arrival';
    const textColor = document.getElementById('add_text_color').value || '#ffffff';
    const bgColor = document.getElementById('add_bg_color').value || '#0099ff';
    
    const preview = document.getElementById('add_badge_preview');
    preview.innerText = title;
    preview.style.color = textColor;
    preview.style.background = bgColor;
}

function syncEditColor(type) {
    if (type === 'text') {
        document.getElementById('edit_label_text_color').value = document.getElementById('edit_text_color_picker').value;
    } else {
        document.getElementById('edit_label_bg_color').value = document.getElementById('edit_bg_color_picker').value;
    }
    updateEditPreview();
}

function updateEditPreview() {
    const title = document.getElementById('edit_label_title').value || 'Sample Label';
    const textColor = document.getElementById('edit_label_text_color').value || '#ffffff';
    const bgColor = document.getElementById('edit_label_bg_color').value || '#0099ff';
    
    const preview = document.getElementById('edit_badge_preview');
    preview.innerText = title;
    preview.style.color = textColor;
    preview.style.background = bgColor;
}
</script>

<?= $this->include('admin/layouts/footer') ?>
