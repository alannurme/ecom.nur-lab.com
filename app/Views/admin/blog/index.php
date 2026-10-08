<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">All Blog Posts</h1>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addPostModal" class="btn btn-circle btn-info font-weight-bold">
                <i class="las la-plus mr-1"></i> Add New Post
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Blog Posts List</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchBlogInput" placeholder="Type & hit enter to search...">
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
                            <th>Category</th>
                            <th>Short Description</th>
                            <th>Published</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="blogTableBody">
                        <?php 
                        $postList = !empty($posts) ? $posts : [
                            ['id' => 1, 'title' => 'Top 10 E-Commerce Trends for 2026', 'category' => 'E-Commerce Tips', 'desc' => 'Discover the key online shopping trends that will dominate this year...', 'status' => 1],
                            ['id' => 2, 'title' => 'How to Choose the Perfect Smartwatch', 'category' => 'Gadgets & Tech', 'desc' => 'A complete buyer guide for selecting the best smartwatch for your lifestyle...', 'status' => 1],
                            ['id' => 3, 'title' => 'Winter Fashion Buying Guide 2026', 'category' => 'Fashion Trends', 'desc' => 'Explore the latest winter clothing styles and popular color palettes...', 'status' => 0],
                        ];
                        foreach ($postList as $index => $post): 
                        ?>
                        <tr class="blog-row" id="blog_row_<?= $post['id'] ?>" data-search="<?= strtolower(esc(($post['title'] ?? '').' '.($post['category'] ?? ''))) ?>">
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="font-weight-bold text-dark fs-14"><?= esc($post['title'] ?? '') ?></div>
                            </td>
                            <td>
                                <span class="badge badge-inline badge-soft-info"><?= esc($post['category'] ?? 'Uncategorized') ?></span>
                            </td>
                            <td>
                                <span class="text-muted fs-13"><?= esc($post['desc'] ?? '') ?></span>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" class="blog-status-toggle" data-id="<?= $post['id'] ?>" <?= ($post['status'] ?? 0) == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit" href="javascript:void(0);">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-blog" data-id="<?= $post['id'] ?>" title="Delete" href="javascript:void(0);">
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

<!-- Modal: Add New Post -->
<div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Create New Blog Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Blog Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Post Title" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Category <span class="text-danger">*</span></label>
                        <select class="form-control aiz-selectpicker" name="category_id" required>
                            <option value="">Select Category</option>
                            <option value="1">E-Commerce Tips</option>
                            <option value="2">Gadgets & Tech</option>
                            <option value="3">Fashion Trends</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Short Description</label>
                        <textarea class="form-control" name="short_description" rows="3" placeholder="Brief summary of the blog post..."></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Full Content</label>
                        <textarea class="form-control" name="content" rows="6" placeholder="Write full article here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Publish Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchBlogInput');
    const rows = document.querySelectorAll('.blog-row');

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

    document.querySelectorAll('.blog-status-toggle').forEach(sw => {
        sw.addEventListener('change', function() {
            const isChecked = this.checked ? 'Published' : 'Unpublished';
            alert('Blog post status updated to: ' + isChecked);
        });
    });

    document.querySelectorAll('.btn-delete-blog').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this blog post?')) {
                const row = document.getElementById('blog_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
