<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Flash Deals</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#createFlashDealModal" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Create New Flash Deal
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">All Flash Deals</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchFlashDealInput" placeholder="Search campaign name...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="las la-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="40">#</th>
                            <th>Title</th>
                            <th>Banner</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Page Link</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="flashDealTableBody">
                        <?php 
                        $dealsList = !empty($flash_deals) ? $flash_deals : [
                            ['id' => 1, 'title' => 'Mega Winter Sale 2026', 'start' => '2026-10-01', 'end' => '2026-10-15', 'status' => 1, 'featured' => 1, 'slug' => 'mega-winter-sale'],
                            ['id' => 2, 'title' => 'Flash Deal Electronics', 'start' => '2026-10-10', 'end' => '2026-10-20', 'status' => 1, 'featured' => 0, 'slug' => 'flash-deal-electronics'],
                            ['id' => 3, 'title' => 'Black Friday Special Campaign', 'start' => '2026-11-20', 'end' => '2026-11-30', 'status' => 0, 'featured' => 0, 'slug' => 'black-friday-special'],
                        ];
                        foreach ($dealsList as $index => $deal): 
                        ?>
                        <tr class="deal-row" id="deal_row_<?= $deal['id'] ?>" data-search="<?= strtolower(esc($deal['title'] ?? '')) ?>">
                            <td><?= $index + 1 ?></td>
                            <td><span class="font-weight-bold text-dark fs-14"><?= esc($deal['title'] ?? '') ?></span></td>
                            <td>
                                <img src="<?= base_url('public/assets/img/placeholder.jpg') ?>" class="rounded h-40px w-80px" style="object-fit: cover;" alt="Banner" onerror="this.onerror=null; this.src='https://via.placeholder.com/120x60?text=Banner';">
                            </td>
                            <td><?= esc($deal['start'] ?? '') ?></td>
                            <td><?= esc($deal['end'] ?? '') ?></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" class="deal-status-toggle" data-id="<?= $deal['id'] ?>" <?= ($deal['status'] ?? 0) == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" class="deal-featured-toggle" data-id="<?= $deal['id'] ?>" <?= ($deal['featured'] ?? 0) == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <div class="input-group input-group-sm" style="max-width: 220px;">
                                    <input type="text" class="form-control" value="<?= base_url('flash-deal/'.$deal['slug']) ?>" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-copy-link" data-url="<?= base_url('flash-deal/'.$deal['slug']) ?>" type="button"><i class="las la-clipboard"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit" href="javascript:void(0);">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-deal" data-id="<?= $deal['id'] ?>" title="Delete" href="javascript:void(0);">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Flash Deal -->
<div class="modal fade" id="createFlashDealModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Create New Flash Deal Campaign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Campaign Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Flash Deal Title" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Banner (1500px X 450px)</label>
                        <input type="file" class="form-control-file" name="banner">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Text Color</label>
                        <select class="form-control" name="text_color">
                            <option value="white">White</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Create Flash Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFlashDealInput');
    const rows = document.querySelectorAll('.deal-row');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                if (searchStr.includes(q)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    document.querySelectorAll('.btn-copy-link').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url);
            alert('Campaign link copied!');
        });
    });

    document.querySelectorAll('.btn-delete-deal').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this flash deal?')) {
                const row = document.getElementById('deal_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
