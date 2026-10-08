<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700"><?= isset($category) ? 'Edit Category' : 'Add New Category' ?></h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary btn-sm">
                <i class="las la-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold"><?= isset($category) ? 'Update Category Information' : 'Category Information' ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?= isset($category) ? base_url('admin/categories/update/' . $category['id']) : base_url('admin/categories/store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Name -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="<?= esc($category['name'] ?? '') ?>" placeholder="Category Name" required>
                            </div>
                        </div>

                        <!-- Parent Category -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Parent Category</label>
                            <div class="col-md-9">
                                <select class="form-control aiz-selectpicker" name="parent_id" data-live-search="true">
                                    <option value="0">No Parent (Main Category)</option>
                                    <?php 
                                    $parentList = isset($all_categories) ? $all_categories : (isset($categories) ? $categories : []);
                                    foreach ($parentList as $catItem): 
                                    ?>
                                        <option value="<?= $catItem['id'] ?>" <?= (isset($category['parent_id']) && $category['parent_id'] == $catItem['id']) ? 'selected' : '' ?>>
                                            <?= esc($catItem['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Digital Category Toggle -->
                        <div class="form-group row align-items-center mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Digital Category</label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="digital" value="1" <?= (!empty($category['digital']) && $category['digital'] == 1) ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Order Level -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Order Level</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="order_level" value="<?= esc($category['order_level'] ?? 0) ?>" placeholder="Order Level">
                                <small class="text-muted">Higher number will show first.</small>
                            </div>
                        </div>

                        <!-- Banner Image Upload Options -->
                        <div class="form-group row mb-4">
                            <label class="col-md-3 col-form-label fs-14 fw-500">Banner Image</label>
                            <div class="col-md-9">
                                
                                <!-- Banner Image Preview Card -->
                                <div class="mb-3" id="banner_preview_container" style="<?= !empty($category['banner_img']) ? '' : 'display:none;' ?>">
                                    <div class="p-2 border rounded bg-white d-inline-block shadow-sm">
                                        <img src="<?= !empty($category['banner_img']) ? base_url($category['banner_img']) : '' ?>" class="img-fit rounded" id="banner_preview_img" style="max-height: 150px; max-width: 280px;" onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                                    </div>
                                </div>

                                <!-- Dual Buttons: Choose from Uploaded Files & Upload from PC -->
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <!-- Button 1: Choose from Uploaded Files (AIZ Uploader Modal Trigger) -->
                                    <div class="d-inline-block">
                                        <input type="hidden" name="banner" id="selected_banner_id" class="selected-files" value="<?= esc($category['banner'] ?? '') ?>">
                                        <button type="button" onclick="openAizUploaderModal()" class="btn btn-primary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center" style="gap: 8px;">
                                            <i class="las la-folder-open fs-18"></i> Choose from Uploaded Files
                                        </button>
                                    </div>

                                    <!-- Button 2: Upload from PC -->
                                    <div class="d-inline-block">
                                        <input type="file" name="banner_file" id="banner_file_input" class="d-none" accept="image/*" onchange="handlePcFileUpload(this)">
                                        <button type="button" onclick="document.getElementById('banner_file_input').click()" class="btn btn-outline-secondary font-weight-bold px-3 py-2 fs-14 rounded-2 d-inline-flex align-items-center bg-white text-dark border" style="gap: 8px; border-color: #ced4da !important;">
                                            <i class="las la-upload fs-18 text-muted"></i> Upload from PC
                                        </button>
                                    </div>
                                </div>

                                <small class="text-muted d-block mt-2">Select an image from uploaded files modal or upload a new file from your PC.</small>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4">
                                <?= isset($category) ? 'Update Category' : 'Save Category' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function handlePcFileUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('banner_preview_img');
            if (img) {
                img.src = e.target.result;
            }
            var container = document.getElementById('banner_preview_container');
            if (container) {
                container.style.display = 'block';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

var selectedFileId = null;
var selectedFileUrl = null;

function openAizUploaderModal() {
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
        $('#selected_banner_id').val(selectedFileId);
        $('#banner_preview_img').attr('src', selectedFileUrl);
        $('#banner_preview_container').show();
        $('#aizUploaderModal').modal('hide');
    } else {
        alert('Please select a file first.');
    }
});

$(document).on('keyup', '#aiz-uploader-search', function() {
    loadUploaderFiles();
});
</script>

<?= $this->include('admin/layouts/footer') ?>
