<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700"><?= isset($brand) ? 'Edit Brand' : 'Add New Brand' ?></h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="<?= base_url('admin/brands') ?>" class="btn btn-secondary btn-sm">
                <i class="las la-arrow-left"></i> Back to Brands
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold"><?= isset($brand) ? 'Update Brand Information' : 'Brand Information' ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?= isset($brand) ? base_url('admin/brands/update/' . $brand['id']) : base_url('admin/brands/store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Name -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Brand Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="<?= esc($brand['name'] ?? '') ?>" placeholder="Brand Name" required>
                            </div>
                        </div>

                        <!-- Brand Logo Options -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Logo</label>
                            <div class="col-md-9">
                                
                                <!-- Brand Logo Preview Card -->
                                <div class="mb-3" id="logo_preview_container" style="<?= !empty($brand['logo_img']) ? '' : 'display:none;' ?>">
                                    <div class="p-2 border rounded bg-white d-inline-block shadow-sm">
                                        <img src="<?= !empty($brand['logo_img']) ? base_url($brand['logo_img']) : '' ?>" class="img-fit rounded" id="logo_preview_img" style="max-height: 150px; max-width: 280px;" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                </div>

                                <!-- Dual Buttons: Choose from Uploaded Files & Upload from PC -->
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <!-- Button 1: Choose from Uploaded Files (AIZ Uploader Modal Trigger) -->
                                    <div class="d-inline-block">
                                        <input type="hidden" name="logo" id="selected_logo_id" class="selected-files" value="<?= esc($brand['logo'] ?? '') ?>">
                                        <button type="button" onclick="openAizUploaderModalForBrand()" class="btn btn-primary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center" style="gap: 8px;">
                                            <i class="las la-folder-open fs-18"></i> Choose from Uploaded Files
                                        </button>
                                    </div>

                                    <!-- Button 2: Upload from PC -->
                                    <div class="d-inline-block">
                                        <input type="file" name="logo_file" id="logo_file_input" class="d-none" accept="image/*" onchange="handleBrandPcFileUpload(this)">
                                        <button type="button" onclick="document.getElementById('logo_file_input').click()" class="btn btn-outline-secondary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center bg-white text-dark border" style="gap: 8px; border-color: #ced4da !important;">
                                            <i class="las la-upload fs-18 text-muted"></i> Upload from PC
                                        </button>
                                    </div>
                                </div>

                                <small class="text-muted d-block mt-2">Select an image from uploaded files modal or upload a new file from your PC.</small>
                            </div>
                        </div>

                        <!-- Meta Title -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Meta Title</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_title" value="<?= esc($brand['meta_title'] ?? '') ?>" placeholder="Meta Title">
                            </div>
                        </div>

                        <!-- Meta Description -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Meta Description</label>
                            <div class="col-md-9">
                                <textarea name="meta_description" rows="4" class="form-control" placeholder="Meta Description"><?= esc($brand['meta_description'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Meta Keywords -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Meta Keywords</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_keywords" value="<?= esc($brand['meta_keywords'] ?? '') ?>" placeholder="Meta Keywords">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4">
                                <?= isset($brand) ? 'Update Brand' : 'Save Brand' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function handleBrandPcFileUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('logo_preview_img');
            if (img) {
                img.src = e.target.result;
            }
            var container = document.getElementById('logo_preview_container');
            if (container) {
                container.style.display = 'block';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

var selectedFileId = null;
var selectedFileUrl = null;

function openAizUploaderModalForBrand() {
    if ($('#aizUploaderModal').length === 0) {
        $.ajax({
            url: '<?= base_url('aiz-uploader') ?>',
            type: 'GET',
            success: function(html) {
                $('body').append(html);
                loadUploaderFiles();
                $('#aizUploaderModal').modal('show');
            },
            error: function(err) {
                console.error(err);
                alert('Could not load uploader modal.');
            }
        });
    } else {
        loadUploaderFiles();
        $('#aizUploaderModal').modal('show');
    }
}

function loadUploaderFiles() {
    var search = $('#aiz-uploader-search').val() || '';
    $.ajax({
        url: '<?= base_url('aiz-uploader/get-uploaded-files') ?>',
        type: 'GET',
        data: { search: search },
        success: function(res) {
            var files = res.data || [];
            var html = '';
            if (files.length > 0) {
                files.forEach(function(file) {
                    var imgUrl = '<?= base_url() ?>' + file.file_name;
                    html += `
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <div class="card h-100 uploader-file-card border text-center p-2 cursor-pointer position-relative" data-id="${file.id}" data-url="${imgUrl}" onclick="selectUploaderFile(this)">
                                <div class="img-fit h-100px w-100 rounded mb-2 overflow-hidden d-flex align-items-center justify-content-center bg-light">
                                    <img src="${imgUrl}" class="img-fluid rounded" style="max-height: 90px;" onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                </div>
                                <div class="text-truncate fs-11 fw-600 text-dark">${file.file_original_name}</div>
                                <div class="selected-badge position-absolute top-0 right-0 p-1" style="display:none;">
                                    <span class="badge badge-primary rounded-circle"><i class="las la-check"></i></span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = '<div class="col-12 text-center py-4 text-muted">No uploaded files found.</div>';
            }
            $('.aiz-uploader-selecte-file-list').html(html);
        }
    });
}

function selectUploaderFile(el) {
    $('.uploader-file-card').removeClass('border-primary shadow-sm').find('.selected-badge').hide();
    $(el).addClass('border-primary shadow-sm').find('.selected-badge').show();
    selectedFileId = $(el).data('id');
    selectedFileUrl = $(el).data('url');
    $('.aiz-uploader-selected').text('1');
}

$(document).on('click', '[data-toggle="aizUploaderAddSelected"]', function() {
    if (selectedFileId && selectedFileUrl) {
        $('#selected_logo_id').val(selectedFileId);
        $('#logo_preview_img').attr('src', selectedFileUrl);
        $('#logo_preview_container').show();
        $('#aizUploaderModal').modal('hide');
    }
});

$(document).on('keyup', '#aiz-uploader-search', function() {
    loadUploaderFiles();
});
</script>

<?= view('admin/layouts/footer') ?>
