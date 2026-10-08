<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700 mb-0">All Uploaded Files</h1>
            <span class="fs-13 text-muted">Manage all media assets, images, and documents in your store library</span>
        </div>
        <div class="col-md-6 text-md-right mt-2 mt-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#uploadFileModal" class="btn btn-primary font-weight-bold px-4 rounded-2 shadow-sm">
                <i class="las la-cloud-upload-alt mr-1 fs-18"></i> Upload New File
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-10 align-items-center border-bottom py-3">
            <div class="col-md-2 mb-2 mb-md-0">
                <h5 class="mb-0 h6 font-weight-bold"><i class="las la-images text-primary mr-1"></i> Media Library</h5>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <button class="btn btn-soft-danger text-danger border border-danger-20 font-weight-bold w-100 fs-13 rounded-2 shadow-sm" type="button" id="bulkDeleteUploadsBtn">
                    <i class="las la-trash mr-1"></i> Delete Selected
                </button>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <select class="form-control" id="filterTypeSelect">
                    <option value="all">All File Types</option>
                    <option value="image">Images Only</option>
                    <option value="document">Documents Only</option>
                    <option value="video">Videos Only</option>
                </select>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select class="form-control" id="sortUploadsSelect">
                    <option value="newest">Sort by Newest</option>
                    <option value="oldest">Sort by Oldest</option>
                    <option value="smallest">Sort by Smallest</option>
                    <option value="largest">Sort by Largest</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control rounded-left border-right-0" id="searchUploadsInput" placeholder="Search files by name...">
                    <div class="input-group-append">
                        <button class="btn btn-primary rounded-right px-3" type="button" id="searchUploadsBtn">
                            <i class="las la-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Select All & Count Control Bar -->
            <div class="form-group mb-4 pb-2 border-bottom d-flex align-items-center justify-content-between">
                <label class="aiz-checkbox mb-0 fw-600 fs-13 text-secondary">
                    <input type="checkbox" id="checkAllFiles">
                    <span class="aiz-square-check"></span>
                    <span class="ml-2">Select All Files</span>
                </label>
                <span class="fs-12 text-muted fw-600" id="fileCountBadge">Showing <?= !empty($uploads) ? count($uploads) : 6 ?> items</span>
            </div>

            <!-- Media Grid -->
            <div class="row gutters-15" id="uploadsGrid">
                <?php
                $uploadsList = !empty($uploads) ? $uploads : [
                    ['id' => 101, 'name' => 'banner_winter_sale', 'ext' => 'png', 'type' => 'image', 'size' => 345000, 'size_formatted' => '336.91 KB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-01'],
                    ['id' => 102, 'name' => 'product_tshirt_blue', 'ext' => 'jpg', 'type' => 'image', 'size' => 184000, 'size_formatted' => '179.68 KB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-02'],
                    ['id' => 103, 'name' => 'electronics_catalog_2026', 'ext' => 'pdf', 'type' => 'document', 'size' => 2450000, 'size_formatted' => '2.34 MB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-03'],
                    ['id' => 104, 'name' => 'promo_video_shorts', 'ext' => 'mp4', 'type' => 'video', 'size' => 15800000, 'size_formatted' => '15.06 MB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-04'],
                    ['id' => 105, 'name' => 'logo_header_light', 'ext' => 'png', 'type' => 'image', 'size' => 45000, 'size_formatted' => '43.94 KB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-05'],
                    ['id' => 106, 'name' => 'size_chart_guide', 'ext' => 'jpg', 'type' => 'image', 'size' => 210000, 'size_formatted' => '205.07 KB', 'file_name' => 'assets/img/placeholder.jpg', 'date' => '2026-10-06'],
                ];
                foreach ($uploadsList as $file):
                    $rawPath = $file['file_name'] ?? $file['url'] ?? 'assets/img/placeholder.jpg';
                    $cleanPath = ltrim(str_replace('public/', '', $rawPath), '/');

                    if (!empty($cleanPath) && strpos($cleanPath, 'uploads/') !== 0 && strpos($cleanPath, 'assets/') !== 0) {
                        if (file_exists(FCPATH . 'uploads/all/' . $cleanPath)) {
                            $cleanPath = 'uploads/all/' . $cleanPath;
                        } elseif (file_exists(FCPATH . 'uploads/product/' . $cleanPath)) {
                            $cleanPath = 'uploads/product/' . $cleanPath;
                        } else {
                            $cleanPath = 'uploads/all/' . $cleanPath;
                        }
                    }

                    $hasPhysicalFile = file_exists(FCPATH . $cleanPath);
                    if (!$hasPhysicalFile && !empty($uploads)) {
                        continue;
                    }
                    $fileUrl = $hasPhysicalFile ? base_url($cleanPath) : base_url('assets/img/placeholder.jpg');

                    $fileName = $file['file_name'] ? pathinfo($file['file_name'], PATHINFO_FILENAME) : ($file['name'] ?? 'file_'.$file['id']);
                    $fileExt = strtolower($file['extension'] ?? pathinfo($cleanPath, PATHINFO_EXTENSION) ?? $file['ext'] ?? 'png');
                    if (empty($fileExt)) $fileExt = 'png';
                    
                    $fileType = $file['type'] ?? $file['file_type'] ?? (in_array($fileExt, ['jpg','jpeg','png','webp','gif']) ? 'image' : ($fileExt === 'mp4' ? 'video' : 'document'));
                    $fileSize = $file['file_size'] ?? $file['size'] ?? 0;
                    $fileSizeFormatted = $file['size_formatted'] ?? (round($fileSize / 1024, 2) . ' KB');
                    $fileDate = $file['created_at'] ?? $file['date'] ?? date('Y-m-d');
                ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4 file-card-item" id="file_box_<?= $file['id'] ?>" data-id="<?= $file['id'] ?>" data-name="<?= strtolower(esc($fileName)) ?>" data-size="<?= $fileSize ?>" data-type="<?= esc($fileType) ?>">
                    <div class="card h-100 border rounded-2 position-relative bg-white shadow-sm hover-shadow-lg transition-all" style="transition: all 0.2s ease-in-out;">
                        <!-- Checkbox & Menu Header -->
                        <div class="d-flex align-items-center justify-content-between p-2 position-absolute w-100" style="top:0; left:0; z-index:5;">
                            <label class="aiz-checkbox mb-0">
                                <input type="checkbox" class="check-one-file" value="<?= $file['id'] ?>">
                                <span class="aiz-square-check bg-white border"></span>
                            </label>

                            <div class="dropdown">
                                <a class="btn btn-xs btn-circle btn-light shadow-sm text-secondary" href="javascript:void(0);" data-toggle="dropdown">
                                    <i class="las la-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 rounded-2">
                                    <a href="javascript:void(0)" class="dropdown-item btn-file-info" 
                                       data-id="<?= $file['id'] ?>" 
                                       data-name="<?= esc($fileName.'.'.$fileExt) ?>"
                                       data-size="<?= esc($fileSizeFormatted) ?>"
                                       data-type="<?= esc($fileType) ?>"
                                       data-date="<?= esc($fileDate) ?>"
                                       data-url="<?= esc($fileUrl) ?>">
                                        <i class="las la-info-circle mr-2 text-info fs-16"></i> Detail Info
                                    </a>
                                    <a href="<?= esc($fileUrl) ?>" download="<?= esc($fileName.'.'.$fileExt) ?>" class="dropdown-item">
                                        <i class="las la-download mr-2 text-success fs-16"></i> Download
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-item btn-copy-link" data-url="<?= esc($fileUrl) ?>">
                                        <i class="las la-clipboard mr-2 text-primary fs-16"></i> Copy Direct Link
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item text-danger btn-delete-file" data-id="<?= $file['id'] ?>">
                                        <i class="las la-trash mr-2 text-danger fs-16"></i> Delete File
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail Area -->
                        <div class="card-file-thumb bg-light text-center d-flex align-items-center justify-content-center border-bottom" style="height: 140px; overflow: hidden;">
                            <?php if ($fileType == 'image'): ?>
                                <img src="<?= esc($fileUrl) ?>" class="img-fit h-100 w-100" style="object-fit: cover;" onerror="this.onerror=null; this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                            <?php elseif ($fileType == 'video'): ?>
                                <div class="text-center">
                                    <i class="las la-file-video text-warning" style="font-size: 52px;"></i>
                                    <span class="badge badge-inline badge-soft-warning fs-10 d-block mt-1">VIDEO</span>
                                </div>
                            <?php else: ?>
                                <div class="text-center">
                                    <i class="las la-file-pdf text-danger" style="font-size: 52px;"></i>
                                    <span class="badge badge-inline badge-soft-danger fs-10 d-block mt-1"><?= strtoupper(esc($fileExt)) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Meta Info -->
                        <div class="card-body p-2 text-left">
                            <h6 class="fs-12 fw-600 mb-1 text-dark text-truncate" title="<?= esc($fileName.'.'.$fileExt) ?>">
                                <?= esc($fileName) ?><span class="text-muted">.<?= esc($fileExt) ?></span>
                            </h6>
                            <div class="d-flex align-items-center justify-content-between text-muted fs-11">
                                <span><?= esc($fileSizeFormatted) ?></span>
                                <span class="badge badge-inline badge-soft-secondary fs-10 uppercase"><?= esc($fileExt) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Detail Info -->
<div class="modal fade" id="fileInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-2">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold"><i class="las la-info-circle text-info mr-1"></i> File Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="bg-light rounded-2 p-3 mb-3 d-flex align-items-center justify-content-center border" style="min-height: 160px;">
                    <img id="modal_file_preview" src="" class="img-fluid rounded shadow-sm" style="max-height: 200px; display:none;">
                    <i id="modal_file_icon" class="las la-file text-secondary" style="font-size: 64px;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1" id="modal_file_name">filename.ext</h5>
                <p class="text-muted fs-13 mb-3" id="modal_file_size">0 KB</p>

                <div class="bg-light p-3 rounded-2 text-left mb-3 border fs-13">
                    <div class="mb-2"><span class="text-muted d-block fs-12">File Type:</span> <strong class="text-dark" id="modal_file_type">IMAGE</strong></div>
                    <div class="mb-2"><span class="text-muted d-block fs-12">Upload Date:</span> <strong class="text-dark" id="modal_file_date">2026-10-01</strong></div>
                    <div><span class="text-muted d-block fs-12">Direct URL Link:</span> 
                        <div class="input-group input-group-sm mt-1">
                            <input type="text" class="form-control" id="modal_file_url" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary font-weight-bold" type="button" id="modalCopyBtn"><i class="las la-clipboard"></i> Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Upload New File -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-2">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold"><i class="las la-cloud-upload-alt text-primary mr-1"></i> Upload New Media File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('admin/uploaded-files/upload') ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                    <?= csrf_field() ?>
                    <div class="border-dashed border-2 border-primary rounded-2 p-5 text-center bg-soft-primary" style="border-style: dashed !important; border-width: 2px !important;">
                        <i class="las la-cloud-upload-alt text-primary" style="font-size: 64px;"></i>
                        <h5 class="font-weight-bold text-dark mt-3 mb-1">Drag & Drop files here to upload</h5>
                        <p class="text-muted fs-14 mb-4">Support images, PDFs, videos, and documents up to 50MB</p>
                        <input type="file" name="media_files[]" id="mediaFileInput" multiple style="display:none;" onchange="document.getElementById('uploadForm').submit();">
                        <button type="button" class="btn btn-primary font-weight-bold px-4 py-2.5 rounded-2 shadow-sm" onclick="document.getElementById('mediaFileInput').click();">
                            <i class="las la-folder-open mr-1 fs-18"></i> Browse Computer Files
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Filter and Sort Handler
    function filterAndSortFiles() {
        var searchQuery = $('#searchUploadsInput').val().trim().toLowerCase();
        var typeFilter = $('#filterTypeSelect').val();
        var sortValue = $('#sortUploadsSelect').val();
        
        var $grid = $('#uploadsGrid');
        var $items = $('.file-card-item');
        var visibleCount = 0;

        $items.each(function() {
            var name = ($(this).data('name') || '').toString();
            var type = ($(this).data('type') || '').toString();
            
            var matchesSearch = !searchQuery || name.indexOf(searchQuery) > -1;
            var matchesType = typeFilter === 'all' || type === typeFilter;

            if (matchesSearch && matchesType) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });

        $('#fileCountBadge').text('Showing ' + visibleCount + ' items');

        // Sorting logic
        var sortedItems = $items.get().sort(function(a, b) {
            var idA = parseInt($(a).data('id')) || 0;
            var idB = parseInt($(b).data('id')) || 0;
            var sizeA = parseFloat($(a).data('size')) || 0;
            var sizeB = parseFloat($(b).data('size')) || 0;

            if (sortValue === 'newest') return idB - idA;
            if (sortValue === 'oldest') return idA - idB;
            if (sortValue === 'smallest') return sizeA - sizeB;
            if (sortValue === 'largest') return sizeB - sizeA;
            return 0;
        });

        $.each(sortedItems, function(idx, itm) {
            $grid.append(itm);
        });
    }

    // Universal Dropdown toggle for 3-dot menu and options
    $(document).off('click', '[data-toggle="dropdown"]').on('click', '[data-toggle="dropdown"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $dropdown = $(this).closest('.dropdown');
        var $menu = $dropdown.find('.dropdown-menu');
        var isVisible = $menu.is(':visible');

        $('.dropdown-menu').removeClass('show').hide();
        $('.dropdown').removeClass('show');

        if (!isVisible) {
            $dropdown.addClass('show');
            $menu.addClass('show').show();
        }
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show').hide();
            $('.dropdown').removeClass('show');
        }
    });

    $(document).on('click', '.dropdown-menu a', function() {
        $('.dropdown-menu').removeClass('show').hide();
        $('.dropdown').removeClass('show');
    });

    // Attach event listeners for search, type filter, and sorting
    $('#searchUploadsInput').on('keyup input', filterAndSortFiles);
    $('#searchUploadsBtn').on('click', filterAndSortFiles);
    $('#filterTypeSelect').on('change', filterAndSortFiles);
    $('#sortUploadsSelect').on('change', filterAndSortFiles);

    // Select All Checkbox
    $('#checkAllFiles').on('change', function() {
        $('.check-one-file').prop('checked', this.checked);
    });

    // Copy Direct Link
    $(document).on('click', '.btn-copy-link', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Direct file link copied to clipboard!');
            });
        } else {
            prompt('Copy link:', url);
        }
    });

    // File Detail Modal
    $(document).on('click', '.btn-file-info', function(e) {
        e.preventDefault();
        var name = $(this).data('name');
        var size = $(this).data('size');
        var type = $(this).data('type');
        var date = $(this).data('date');
        var url = $(this).data('url');

        $('#modal_file_name').text(name);
        $('#modal_file_size').text(size);
        $('#modal_file_type').text((type || '').toUpperCase());
        $('#modal_file_date').text(date);
        $('#modal_file_url').val(url);

        var $preview = $('#modal_file_preview');
        var $icon = $('#modal_file_icon');

        if (type === 'image') {
            $preview.attr('src', url).show();
            $icon.hide();
        } else {
            $preview.hide();
            $icon.show();
            if (type === 'video') {
                $icon.attr('class', 'las la-file-video text-warning').css('font-size', '64px');
            } else {
                $icon.attr('class', 'las la-file-pdf text-danger').css('font-size', '64px');
            }
        }

        $('#fileInfoModal').modal('show');
    });

    // Modal Copy URL
    $('#modalCopyBtn').on('click', function() {
        var url = $('#modal_file_url').val();
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                alert('File URL copied!');
            });
        } else {
            prompt('Copy link:', url);
        }
    });

    // Single Delete
    $(document).on('click', '.btn-delete-file', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this file permanently?')) {
            $.post('<?= base_url('admin/uploaded-files/delete') ?>/' + id, function(res) {
                $('#file_box_' + id).fadeOut(300, function() {
                    $(this).remove();
                    filterAndSortFiles();
                });
            }, 'json').fail(function() {
                alert('Error deleting file. Please try again.');
            });
        }
    });

    // Bulk Delete
    $('#bulkDeleteUploadsBtn').on('click', function(e) {
        e.preventDefault();
        var $checked = $('.check-one-file:checked');
        if ($checked.length === 0) {
            alert('Please select at least one file to delete.');
            return;
        }

        var ids = [];
        $checked.each(function() {
            ids.push($(this).val());
        });

        if (confirm('Delete selected ' + ids.length + ' file(s) permanently?')) {
            $.post('<?= base_url('admin/uploaded-files/bulk-delete') ?>', { ids: ids }, function(res) {
                ids.forEach(function(id) {
                    $('#file_box_' + id).remove();
                });
                $('#checkAllFiles').prop('checked', false);
                filterAndSortFiles();
            }, 'json').fail(function() {
                alert('Error performing bulk deletion.');
            });
        }
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
