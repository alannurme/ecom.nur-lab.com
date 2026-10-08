<?= $this->include('admin/layouts/header') ?>

<?php
$currentType = $_GET['type'] ?? 'all';
?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-bold">All Customers</h1>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#add_new_customer_modal" class="btn btn-circle btn-info font-weight-bold">
                <i class="las la-plus mr-1"></i> Add New Customer
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card shadow-sm border-0 rounded-2">
        <!-- Nav Tabs -->
        <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom border-light px-25px pt-3">
            <div class="table-tabs-container">
                <ul class="nav nav-tabs border-0" id="customerTab" role="tablist">
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link filter-tab px-3 pb-15px fs-14 fw-600 <?= $currentType == 'all' ? 'active text-primary border-bottom border-primary' : 'text-muted' ?>" data-type="all">
                            All Customers
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a href="javascript:void(0);" class="nav-link filter-tab px-3 pb-15px fs-14 fw-600 <?= $currentType == 'banned' ? 'active text-primary border-bottom border-primary' : 'text-muted' ?>" data-type="banned">
                            Banned
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a href="javascript:void(0);" class="nav-link filter-tab px-3 pb-15px fs-14 fw-600 <?= $currentType == 'suspicious' ? 'active text-primary border-bottom border-primary' : 'text-muted' ?>" data-type="suspicious">
                            Suspicious
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a href="javascript:void(0);" class="nav-link filter-tab px-3 pb-15px fs-14 fw-600 <?= $currentType == 'verified' ? 'active text-primary border-bottom border-primary' : 'text-muted' ?>" data-type="verified">
                            Verified
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a href="javascript:void(0);" class="nav-link filter-tab px-3 pb-15px fs-14 fw-600 <?= $currentType == 'unverified' ? 'active text-primary border-bottom border-primary' : 'text-muted' ?>" data-type="unverified">
                            Unverified
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-header row gutters-5 border-0 mt-2">
            <div class="col-md-4">
                <div class="input-group mb-0 border border-light px-3 bg-light rounded-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-transparent px-0">
                            <i class="las la-search text-secondary"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-control-sm border-0 px-2 bg-transparent" id="search_input" placeholder="Type & search customers...">
                </div>
            </div>

            <div class="col-md-2 ml-auto">
                <div class="dropdown">
                    <button class="btn border dropdown-toggle w-100 text-secondary fs-14" type="button" id="bulkActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Bulk Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bulkActionBtn">
                        <a class="dropdown-item text-danger" href="javascript:void(0);" id="bulkDeleteBtn">
                            <i class="las la-trash mr-1"></i> Delete selection
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="40">
                                <div class="form-group mb-0">
                                    <label class="aiz-checkbox mb-0">
                                        <input type="checkbox" id="checkAll">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Package</th>
                            <th>Wallet Balance</th>
                            <th>Banned</th>
                            <th>Suspicious</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="customer_table_body">
                        <?php 
                        $customerList = !empty($customers) ? $customers : [
                            ['id' => 8, 'name' => 'Mr. Customer', 'email' => 'customer@example.com', 'phone' => '+8801700000008', 'balance' => 0.00, 'banned' => 0, 'suspicious' => 0, 'verified' => 1],
                            ['id' => 10, 'name' => 'Md Saidur Rahman Shahadat', 'email' => 'mdsaidurrahman@example.com', 'phone' => '+8801800000010', 'balance' => 0.00, 'banned' => 0, 'suspicious' => 0, 'verified' => 1],
                            ['id' => 11, 'name' => 'pHqghUme', 'email' => 'testing@example.com', 'phone' => '+8801900000011', 'balance' => 0.00, 'banned' => 1, 'suspicious' => 0, 'verified' => 0],
                            ['id' => 12, 'name' => 'pHqghUme', 'email' => 'testing2@example.com', 'phone' => '+8801900000012', 'balance' => 0.00, 'banned' => 0, 'suspicious' => 1, 'verified' => 0],
                            ['id' => 13, 'name' => 'pHqghUme', 'email' => 'testing3@example.com', 'phone' => '+8801900000013', 'balance' => 0.00, 'banned' => 0, 'suspicious' => 0, 'verified' => 0],
                        ];
                        foreach ($customerList as $customer): 
                            $isBanned = $customer['banned'] ?? 0;
                            $isSuspicious = $customer['suspicious'] ?? $customer['is_suspicious'] ?? 0;
                            $isVerified = $customer['verified'] ?? (!empty($customer['email_verified_at']) ? 1 : 0);
                        ?>
                        <tr class="customer-row" 
                            id="row_<?= $customer['id'] ?>"
                            data-name="<?= strtolower(esc($customer['name'] ?? '')) ?>"
                            data-email="<?= strtolower(esc($customer['email'] ?? '')) ?>"
                            data-banned="<?= $isBanned ?>" 
                            data-suspicious="<?= $isSuspicious ?>"
                            data-verified="<?= $isVerified ?>">
                            <td>
                                <div class="form-group mb-0">
                                    <label class="aiz-checkbox mb-0">
                                        <input type="checkbox" class="check-one" value="<?= $customer['id'] ?>">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm mr-2 rounded-circle bg-soft-primary text-primary font-weight-bold d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                        <?= strtoupper(substr($customer['name'] ?? 'C', 0, 1)) ?>
                                    </span>
                                    <div>
                                        <div class="font-weight-bold text-dark customer-name"><?= esc($customer['name'] ?? 'N/A') ?></div>
                                        <small class="text-muted">ID: #<?= $customer['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="customer-email"><?= esc($customer['email'] ?? 'N/A') ?></td>
                            <td><?= esc($customer['phone'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-inline badge-soft-info">Free Package</span></td>
                            <td class="fw-600">$<?= number_format($customer['balance'] ?? 0, 2) ?></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" class="toggle-switch" data-id="<?= $customer['id'] ?>" data-field="banned" <?= $isBanned == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-warning mb-0">
                                    <input type="checkbox" class="toggle-switch" data-id="<?= $customer['id'] ?>" data-field="suspicious" <?= $isSuspicious == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm btn-login" href="javascript:void(0);" data-id="<?= $customer['id'] ?>" data-name="<?= esc($customer['name'] ?? '') ?>" title="Log in as customer">
                                    <i class="las la-sign-in-alt"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn-profile" href="javascript:void(0);" 
                                   data-id="<?= $customer['id'] ?>" 
                                   data-name="<?= esc($customer['name'] ?? '') ?>" 
                                   data-email="<?= esc($customer['email'] ?? 'N/A') ?>" 
                                   data-phone="<?= esc($customer['phone'] ?? 'N/A') ?>"
                                   data-balance="$<?= number_format($customer['balance'] ?? 0, 2) ?>"
                                   title="Profile">
                                    <i class="las la-eye"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete" data-id="<?= $customer['id'] ?>" title="Delete">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- Empty Row Indicator -->
                        <tr id="empty_row" style="display: none;">
                            <td colspan="9" class="text-center py-4 text-muted fs-14">
                                <i class="las la-info-circle fs-20 align-middle mr-1 text-info"></i> No customer record found in this view.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add New Customer -->
<div class="modal fade" id="add_new_customer_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/customers/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Customer Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="customer@example.com">
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Phone Number</label>
                        <input type="text" class="form-control" name="phone" placeholder="+8801700000000">
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Create Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View Customer Profile -->
<div class="modal fade" id="view_profile_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-weight-bold">Customer Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pb-4">
                <div class="avatar avatar-lg mx-auto mb-3 bg-soft-primary text-primary font-weight-bold rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px; font-size:24px;" id="profile_avatar">
                    C
                </div>
                <h4 class="font-weight-bold text-dark mb-1" id="profile_name">Customer Name</h4>
                <p class="text-muted mb-3" id="profile_email">email@example.com</p>
                <div class="row text-left bg-light p-3 rounded-2 mx-1">
                    <div class="col-6 mb-2">
                        <span class="text-muted fs-12 d-block">Phone Number</span>
                        <strong class="text-dark fs-14" id="profile_phone">+8801700000000</strong>
                    </div>
                    <div class="col-6 mb-2">
                        <span class="text-muted fs-12 d-block">Wallet Balance</span>
                        <strong class="text-success fs-14" id="profile_balance">$0.00</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted fs-12 d-block">Package</span>
                        <span class="badge badge-soft-info">Free Package</span>
                    </div>
                    <div class="col-6">
                        <span class="text-muted fs-12 d-block">Account Status</span>
                        <span class="badge badge-soft-success">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filter-tab');
    const rows = document.querySelectorAll('.customer-row');
    const emptyRow = document.getElementById('empty_row');

    function filterTable(type, query) {
        let visibleCount = 0;
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const email = row.getAttribute('data-email') || '';
            const isBanned = row.getAttribute('data-banned') === '1';
            const isSuspicious = row.getAttribute('data-suspicious') === '1';
            const isVerified = row.getAttribute('data-verified') === '1';

            let matchesTab = false;
            if (type === 'all') matchesTab = true;
            else if (type === 'banned') matchesTab = isBanned;
            else if (type === 'suspicious') matchesTab = isSuspicious;
            else if (type === 'verified') matchesTab = isVerified;
            else if (type === 'unverified') matchesTab = !isVerified;

            let matchesSearch = true;
            if (query) {
                matchesSearch = name.includes(query) || email.includes(query);
            }

            if (matchesTab && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 ? '' : 'none';
        }
    }

    let activeTabType = 'all';

    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            tabs.forEach(t => {
                t.classList.remove('active', 'text-primary', 'border-bottom', 'border-primary');
                t.classList.add('text-muted');
            });
            this.classList.add('active', 'text-primary', 'border-bottom', 'border-primary');
            this.classList.remove('text-muted');

            activeTabType = this.getAttribute('data-type');
            const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
            filterTable(activeTabType, query);
        });
    });

    const searchInput = document.getElementById('search_input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            filterTable(activeTabType, query);
        });
    }

    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const checkOnes = document.querySelectorAll('.check-one');
            checkOnes.forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }

    document.querySelectorAll('.toggle-switch').forEach(sw => {
        sw.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const field = this.getAttribute('data-field');
            const isChecked = this.checked ? 1 : 0;
            const row = document.getElementById('row_' + id);
            if (row) {
                row.setAttribute('data-' + field, isChecked);
            }
            alert('Customer ' + field + ' status updated to: ' + (isChecked ? 'ON' : 'OFF'));
        });
    });

    document.querySelectorAll('.btn-login').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = this.getAttribute('data-name');
            alert('Logging in as customer: ' + name);
        });
    });

    document.querySelectorAll('.btn-profile').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const phone = this.getAttribute('data-phone');
            const balance = this.getAttribute('data-balance');

            document.getElementById('profile_name').innerText = name;
            document.getElementById('profile_email').innerText = email;
            document.getElementById('profile_phone').innerText = phone;
            document.getElementById('profile_balance').innerText = balance;
            document.getElementById('profile_avatar').innerText = name.charAt(0).toUpperCase();

            $('#view_profile_modal').modal('show');
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this customer?')) {
                const row = document.getElementById('row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
