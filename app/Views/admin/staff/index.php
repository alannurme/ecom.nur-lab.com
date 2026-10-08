<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">All Staffs</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0)" class="btn btn-primary rounded-2 px-3" data-toggle="modal" data-target="#addStaffModal">
                <i class="las la-plus mr-1"></i> Add New Staff
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 h6 font-weight-bold">Staff List</h5>
            <div class="w-250px">
                <input type="text" class="form-control form-control-sm" placeholder="Search staff name or email...">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $staffList = [
                            ['id' => 1, 'name' => 'Manager Admin', 'email' => 'manager@nur-lab.com', 'phone' => '+880 1711-000111', 'role' => 'Manager'],
                            ['id' => 2, 'name' => 'Support Operator', 'email' => 'support@nur-lab.com', 'phone' => '+880 1822-222333', 'role' => 'Support Executive'],
                            ['id' => 3, 'name' => 'Order Manager', 'email' => 'orders@nur-lab.com', 'phone' => '+880 1933-444555', 'role' => 'Order Specialist'],
                        ];
                        foreach ($staffList as $index => $staff):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark"><?= esc($staff['name']) ?></td>
                            <td><?= esc($staff['email']) ?></td>
                            <td><?= esc($staff['phone']) ?></td>
                            <td><span class="badge badge-inline badge-soft-info"><?= esc($staff['role']) ?></span></td>
                            <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Edit">
                                    <i class="las la-pen"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
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

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Add New Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/staff/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="staff@example.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+880 1700-000000">
                    </div>
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fs-13 fw-500">Assign Role</label>
                        <select name="role_id" class="form-control aiz-selectpicker" required>
                            <option value="1">Manager</option>
                            <option value="2">Support Executive</option>
                            <option value="3">Order Specialist</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-2" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4">Save Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
