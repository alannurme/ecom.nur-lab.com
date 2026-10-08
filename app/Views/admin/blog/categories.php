<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">All Blog Categories</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addCategoryModal" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Add New Category
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Blog Categories</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchCategoryInput" placeholder="Search category...">
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
                            <th width="60">#</th>
                            <th>Category Name</th>
                            <th>Total Posts</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        <?php 
                        $categoryList = !empty($categories) ? $categories : [
                            ['id' => 1, 'name' => 'E-Commerce Tips', 'count' => 12],
                            ['id' => 2, 'name' => 'Gadgets & Tech', 'count' => 24],
                            ['id' => 3, 'name' => 'Fashion Trends', 'count' => 18],
                            ['id' => 4, 'name' => 'Lifestyle & Guides', 'count' => 9],
                        ];
                        foreach ($categoryList as $index => $cat): 
                        ?>
                        <tr class="cat-row" id="cat_row_<?= $cat['id'] ?>" data-name="<?= strtolower(esc($cat['name'] ?? '')) ?>">
                            <td><?= $index + 1 ?></td>
                            <td><span class="font-weight-bold text-dark fs-14"><?= esc($cat['name'] ?? '') ?></span></td>
                            <td><span class="badge badge-inline badge-soft-info"><?= esc($cat['count'] ?? 0) ?> Posts</span></td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit" href="javascript:void(0);">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-cat" data-id="<?= $cat['id'] ?>" title="Delete" href="javascript:void(0);">
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

<!-- Modal: Add New Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category_name" placeholder="Category Name" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCategoryInput');
    const rows = document.querySelectorAll('.cat-row');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                if (name.includes(q)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    document.querySelectorAll('.btn-delete-cat').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this category?')) {
                const row = document.getElementById('cat_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
