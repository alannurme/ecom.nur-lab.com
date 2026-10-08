<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">General Settings</h1>
    <span class="fs-13 text-muted">Configure basic website identity, logos, system details, and primary contact info</span>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="px-3 px-md-2rem mb-3">
        <div class="alert alert-success border-0 shadow-sm rounded-2">
            <i class="las la-check-circle mr-2 fs-18"></i> <?= session()->getFlashdata('success') ?>
        </div>
    </div>
<?php endif; ?>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-12">
            <!-- General Information -->
            <div class="card shadow-sm border-0 rounded-2 mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">System Identity & Basic Info</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- System Name -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">System Name</label>
                            <div class="col-md-9">
                                <input type="text" name="website_name" class="form-control" value="<?= esc($site_name) ?>" placeholder="Ex: NUR-LAB ECOM" required>
                            </div>
                        </div>

                        <!-- Site Motto / Tagline -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Site Motto / Tagline</label>
                            <div class="col-md-9">
                                <input type="text" name="site_motto" class="form-control" value="<?= esc($site_motto) ?>" placeholder="Ex: Premium Online Shopping Platform">
                            </div>
                        </div>

                        <!-- System Logo -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">System Logo</label>
                            <div class="col-md-9">
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <!-- Choose from Uploaded Files Button -->
                                    <button type="button" class="btn btn-primary rounded-2 px-3 fw-600 btn-choose-uploaded" data-input="#system_logo_input" data-preview="#system_logo_preview" data-filename="#system_logo_filename">
                                        <i class="las la-folder-open mr-1"></i> Choose from Uploaded Files
                                    </button>
                                    <input type="hidden" name="system_logo" id="system_logo_input" value="<?= esc($system_logo ?? '') ?>">

                                    <!-- Upload from Local PC Button -->
                                    <label class="btn btn-outline-secondary rounded-2 px-3 mb-0 fw-600 cursor-pointer">
                                        <i class="las la-upload mr-1"></i> Upload from PC
                                        <input type="file" name="system_logo_file" class="d-none pc-file-input" data-target="#system_logo_filename" data-preview="#system_logo_preview">
                                    </label>

                                    <!-- Current Set Logo Thumbnail Preview -->
                                    <div class="d-flex align-items-center bg-light border rounded-2 p-1 px-2" style="min-height: 38px;">
                                        <span class="fs-12 text-muted mr-2 fw-600">Current Logo:</span>
                                        <img id="system_logo_preview" src="<?= !empty($system_logo) ? base_url($system_logo) : base_url('assets/img/logo.png') ?>" class="h-30px max-w-100px border rounded bg-white p-1" onerror="this.src='<?= base_url('assets/img/logo.png') ?>';">
                                    </div>

                                    <span id="system_logo_filename" class="fs-12 text-muted fw-500"></span>
                                </div>
                                <small class="text-muted d-block mt-1">Will be displayed on admin header and invoices.</small>
                            </div>
                        </div>

                        <!-- Admin Layout Logo -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Admin Sidebar Logo</label>
                            <div class="col-md-9">
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <!-- Choose from Uploaded Files Button -->
                                    <button type="button" class="btn btn-primary rounded-2 px-3 fw-600 btn-choose-uploaded" data-input="#admin_logo_input" data-preview="#admin_logo_preview" data-filename="#admin_logo_filename">
                                        <i class="las la-folder-open mr-1"></i> Choose from Uploaded Files
                                    </button>
                                    <input type="hidden" name="admin_logo" id="admin_logo_input" value="<?= esc($admin_logo ?? '') ?>">

                                    <!-- Upload from Local PC Button -->
                                    <label class="btn btn-outline-secondary rounded-2 px-3 mb-0 fw-600 cursor-pointer">
                                        <i class="las la-upload mr-1"></i> Upload from PC
                                        <input type="file" name="admin_logo_file" class="d-none pc-file-input" data-target="#admin_logo_filename" data-preview="#admin_logo_preview">
                                    </label>

                                    <!-- Current Set Logo Thumbnail Preview -->
                                    <div class="d-flex align-items-center bg-light border rounded-2 p-1 px-2" style="min-height: 38px;">
                                        <span class="fs-12 text-muted mr-2 fw-600">Current Logo:</span>
                                        <img id="admin_logo_preview" src="<?= !empty($admin_logo) ? base_url($admin_logo) : base_url('assets/img/logo.png') ?>" class="h-30px max-w-100px border rounded bg-white p-1" onerror="this.src='<?= base_url('assets/img/logo.png') ?>';">
                                    </div>

                                    <span id="admin_logo_filename" class="fs-12 text-muted fw-500"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Favicon</label>
                            <div class="col-md-9">
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <!-- Choose from Uploaded Files Button -->
                                    <button type="button" class="btn btn-primary rounded-2 px-3 fw-600 btn-choose-uploaded" data-input="#site_favicon_input" data-preview="#site_favicon_preview" data-filename="#site_favicon_filename">
                                        <i class="las la-folder-open mr-1"></i> Choose from Uploaded Files
                                    </button>
                                    <input type="hidden" name="site_favicon" id="site_favicon_input" value="<?= esc($site_favicon ?? '') ?>">

                                    <!-- Upload from Local PC Button -->
                                    <label class="btn btn-outline-secondary rounded-2 px-3 mb-0 fw-600 cursor-pointer">
                                        <i class="las la-upload mr-1"></i> Upload from PC
                                        <input type="file" name="site_favicon_file" class="d-none pc-file-input" data-target="#site_favicon_filename" data-preview="#site_favicon_preview">
                                    </label>

                                    <!-- Current Set Logo Thumbnail Preview -->
                                    <div class="d-flex align-items-center bg-light border rounded-2 p-1 px-2" style="min-height: 38px;">
                                        <span class="fs-12 text-muted mr-2 fw-600">Current Favicon:</span>
                                        <img id="site_favicon_preview" src="<?= !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/logo.png') ?>" class="h-30px max-w-100px border rounded bg-white p-1" onerror="this.src='<?= base_url('assets/img/logo.png') ?>';">
                                    </div>

                                    <span id="site_favicon_filename" class="fs-12 text-muted fw-500"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Timezone -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">System Timezone</label>
                            <div class="col-md-9">
                                <select name="timezone" class="form-control aiz-selectpicker" data-live-search="true">
                                    <option value="Asia/Dhaka" selected>Asia/Dhaka (GMT+6)</option>
                                    <option value="UTC">UTC (GMT+0)</option>
                                    <option value="America/New_York">America/New_York (EST)</option>
                                    <option value="Europe/London">Europe/London (GMT)</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">
                                <i class="las la-save mr-1"></i> Save Basic Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact & Support Details -->
            <div class="card shadow-sm border-0 rounded-2 mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Contact & Support Information</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                        <?= csrf_field() ?>

                        <!-- Contact Email -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Contact / Support Email</label>
                            <div class="col-md-9">
                                <input type="email" name="contact_email" class="form-control" value="<?= esc($contact_email) ?>" required>
                            </div>
                        </div>

                        <!-- Contact Phone -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Contact / Support Phone</label>
                            <div class="col-md-9">
                                <input type="text" name="contact_phone" class="form-control" value="<?= esc($contact_phone) ?>" required>
                            </div>
                        </div>

                        <!-- Contact Address -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Store Physical Address</label>
                            <div class="col-md-9">
                                <textarea name="contact_address" class="form-control" rows="3"><?= esc($contact_address ?? 'Dhaka, Bangladesh') ?></textarea>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">
                                <i class="las la-save mr-1"></i> Save Contact Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Global Currency & Regional Formats -->
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Currency & Regional Format</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/settings/save') ?>" method="POST">
                        <?= csrf_field() ?>

                        <!-- System Default Currency -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">System Default Currency</label>
                            <div class="col-md-9">
                                <select name="system_default_currency" class="form-control aiz-selectpicker">
                                    <option value="USD">U.S. Dollar ($)</option>
                                    <option value="BDT" selected>Bangladeshi Taka (৳)</option>
                                    <option value="EUR">Euro (€)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Symbol Format -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Currency Symbol Format</label>
                            <div class="col-md-9">
                                <select name="currency_symbol_format" class="form-control aiz-selectpicker">
                                    <option value="1" selected>[Symbol][Amount] (Ex: $100)</option>
                                    <option value="2">[Amount][Symbol] (Ex: 100$)</option>
                                    <option value="3">[Symbol] [Amount] (Ex: $ 100)</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 fw-600 rounded-2">
                                <i class="las la-save mr-1"></i> Save Regional Format
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Uploaded Files Selector Modal -->
<div class="modal fade" id="mediaSelectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-2">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold"><i class="las la-images text-primary mr-1"></i> Select File from Media Library</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3" style="max-height: 450px; overflow-y: auto;">
                <div class="row gutters-10">
                    <?php 
                    $mediaList = !empty($uploads) ? $uploads : [
                        ['id' => 101, 'file_name' => 'assets/img/placeholder.jpg', 'type' => 'image'],
                        ['id' => 102, 'file_name' => 'assets/img/logo.png', 'type' => 'image']
                    ];
                    foreach ($mediaList as $item):
                        $itemUrl = !empty($item['file_name']) ? base_url($item['file_name']) : base_url('assets/img/placeholder.jpg');
                        $itemVal = $item['id'] ?? $itemUrl;
                    ?>
                    <div class="col-3 col-md-2 mb-3">
                        <div class="media-choice-item border rounded p-1 cursor-pointer bg-white text-center shadow-sm h-100 position-relative" data-val="<?= esc($itemVal) ?>" data-url="<?= esc($itemUrl) ?>">
                            <img src="<?= esc($itemUrl) ?>" class="img-fit h-80px w-100 rounded" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                            <small class="d-block text-truncate mt-1 fs-11 text-muted"><?= esc(basename($item['file_name'] ?? 'file')) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer border-top">
                <a href="<?= base_url('admin/uploaded-files') ?>" target="_blank" class="btn btn-link text-primary mr-auto">
                    <i class="las la-external-link-alt mr-1"></i> Open Full Uploaded Files Page
                </a>
                <button type="button" class="btn btn-secondary rounded-2" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var currentTargetInput = null;
    var currentTargetPreview = null;
    var currentTargetFilename = null;

    $('.pc-file-input').on('change', function(e) {
        var fileName = $(this).val().split('\\').pop();
        var targetSpan = $(this).data('target');
        var previewImg = $(this).data('preview');
        
        if (fileName && targetSpan) {
            $(targetSpan).html('<i class="las la-check-circle text-success ml-2"></i> Selected: ' + fileName);
        }

        if (e.target.files && e.target.files[0] && previewImg) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewImg).attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    $('.btn-choose-uploaded').on('click', function(e) {
        e.preventDefault();
        currentTargetInput = $($(this).data('input'));
        currentTargetPreview = $($(this).data('preview'));
        currentTargetFilename = $($(this).data('filename'));
        
        $('#mediaSelectModal').modal('show');
    });

    $(document).on('click', '.media-choice-item', function() {
        var selectedVal = $(this).data('val');
        var selectedUrl = $(this).data('url');

        if (currentTargetInput) {
            currentTargetInput.val(selectedVal);
        }
        if (currentTargetPreview) {
            currentTargetPreview.attr('src', selectedUrl);
        }
        if (currentTargetFilename) {
            currentTargetFilename.html('<i class="las la-check-circle text-success ml-2"></i> File Selected');
        }

        $('#mediaSelectModal').modal('hide');
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
