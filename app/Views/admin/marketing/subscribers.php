<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">All Subscribers</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Newsletter Email Subscribers List</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchSubscriberInput" placeholder="Search subscriber email...">
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
                            <th width="50">#</th>
                            <th>Email Address</th>
                            <th>Subscription Date</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="subscriberTableBody">
                        <?php 
                        $subList = !empty($subscribers) ? $subscribers : [
                            ['id' => 1, 'email' => 'alex.johnson@example.com', 'date' => '2026-10-01 10:15'],
                            ['id' => 2, 'email' => 'maria.gomez@example.com', 'date' => '2026-10-02 14:30'],
                            ['id' => 3, 'email' => 'david.smith@example.com', 'date' => '2026-10-03 16:45'],
                            ['id' => 4, 'email' => 'sophia.brown@example.com', 'date' => '2026-10-04 18:20'],
                        ];
                        foreach ($subList as $index => $sub): 
                        ?>
                        <tr class="sub-row" id="sub_row_<?= $sub['id'] ?>" data-search="<?= strtolower(esc($sub['email'] ?? '')) ?>">
                            <td><?= $index + 1 ?></td>
                            <td><span class="font-weight-bold text-dark fs-14"><?= esc($sub['email'] ?? '') ?></span></td>
                            <td><?= esc($sub['date'] ?? '') ?></td>
                            <td class="text-right">
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-sub" data-id="<?= $sub['id'] ?>" title="Delete" href="javascript:void(0);">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchSubscriberInput');
    const rows = document.querySelectorAll('.sub-row');

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

    document.querySelectorAll('.btn-delete-sub').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this subscriber?')) {
                const row = document.getElementById('sub_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
