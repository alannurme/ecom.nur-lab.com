<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">All Delivery Boys</h1>
        </div>
        <div class="col text-right">
            <a href="<?= base_url('admin/delivery-boys/create') ?>" class="btn btn-circle btn-info">
                <span>Add New Delivery Boy</span>
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Delivery Boy List</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <input type="text" class="form-control form-control-sm" placeholder="Search Delivery Boy...">
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Total Collection</th>
                        <th>Earnings</th>
                        <th>Status</th>
                        <th class="text-right">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($delivery_boys)): ?>
                        <?php foreach ($delivery_boys as $key => $boy): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= esc($boy['name']) ?></td>
                            <td><?= esc($boy['email']) ?></td>
                            <td><?= esc($boy['phone'] ?? 'N/A') ?></td>
                            <td>$0.00</td>
                            <td>$0.00</td>
                            <td>
                                <span class="badge badge-inline badge-success">Active</span>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No Delivery Boys found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
