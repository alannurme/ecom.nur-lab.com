<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Staff Permissions & Roles</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0)" class="btn btn-primary rounded-2 px-3" data-toggle="modal" data-target="#addRoleModal">
                <i class="las la-plus mr-1"></i> Add New Role
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Configured Staff Roles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions Count</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $roles = [
                            ['id' => 1, 'name' => 'Super Admin', 'permissions' => 'All System Permissions'],
                            ['id' => 2, 'name' => 'Manager', 'permissions' => '45 Permissions Granted'],
                            ['id' => 3, 'name' => 'Support Executive', 'permissions' => '12 Permissions Granted'],
                            ['id' => 4, 'name' => 'Order Specialist', 'permissions' => '18 Permissions Granted'],
                        ];
                        foreach ($roles as $index => $role):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark"><?= esc($role['name']) ?></td>
                            <td><span class="badge badge-inline badge-soft-success"><?= esc($role['permissions']) ?></span></td>
                            <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Edit Permissions">
                                    <i class="las la-pen"></i>
                                </a>
                                <?php if ($role['id'] != 1): ?>
                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete Role">
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

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Add New Staff Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/staff/roles/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Role Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Accountant, Warehouse Manager" required>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-2" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
