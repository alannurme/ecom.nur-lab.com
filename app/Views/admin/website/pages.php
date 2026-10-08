<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Website Pages</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="<?= base_url('admin/website/pages/create') ?>" class="btn btn-primary rounded-2 px-3">
                <i class="las la-plus mr-1"></i> Add New Page
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">All Custom Pages</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>Name</th>
                            <th>URL / Slug</th>
                            <th>Page Type</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pages = [
                            ['id' => 1, 'title' => 'Home Page', 'slug' => 'home', 'type' => 'System (Home)'],
                            ['id' => 2, 'title' => 'Terms & Conditions', 'slug' => 'terms', 'type' => 'Custom'],
                            ['id' => 3, 'title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'type' => 'Custom'],
                            ['id' => 4, 'title' => 'Return & Refund Policy', 'slug' => 'return-policy', 'type' => 'Custom'],
                            ['id' => 5, 'title' => 'Support Policy', 'slug' => 'support-policy', 'type' => 'Custom'],
                            ['id' => 6, 'title' => 'About Us', 'slug' => 'about-us', 'type' => 'Custom'],
                        ];
                        foreach ($pages as $index => $page):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark"><?= esc($page['title']) ?></td>
                            <td class="text-muted"><a href="<?= base_url($page['slug']) ?>" target="_blank" class="text-reset"><?= base_url($page['slug']) ?></a></td>
                            <td><span class="badge badge-inline badge-soft-<?= $page['type'] === 'Custom' ? 'info' : 'primary' ?>"><?= esc($page['type']) ?></span></td>
                            <td class="text-right">
                                <a href="<?= base_url('admin/website/pages/edit/' . $page['id']) ?>" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Edit">
                                    <i class="las la-pen"></i>
                                </a>
                                <?php if ($page['type'] === 'Custom'): ?>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?= $page['id'] ?>)" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
                                    <i class="las la-trash"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this custom page?')) {
        alert('Page deleted successfully (Demo Action).');
    }
}
</script>

<?= $this->include('admin/layouts/footer') ?>
