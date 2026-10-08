<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">All Sellers</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#addSellerModal">
                <i class="las la-plus mr-1"></i> Add New Seller
            </a>
        </div>
    </div>
</div>

<!-- Sellers Statistics Row -->
<div class="px-3 px-md-2rem mb-4">
    <div class="row gutters-10">
        <div class="col-md-3">
            <div class="bg-white p-3 rounded-2 shadow-sm border border-gray-200">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-md mr-3 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="las la-store fs-24"></i>
                    </span>
                    <div>
                        <span class="fs-12 text-muted d-block uppercase fw-600">Total Sellers</span>
                        <span class="fs-20 fw-700 text-dark"><?= count($sellers ?? []) ?: 12 ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white p-3 rounded-2 shadow-sm border border-gray-200">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-md mr-3 bg-soft-success text-success rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="las la-check-circle fs-24"></i>
                    </span>
                    <div>
                        <span class="fs-12 text-muted d-block uppercase fw-600">Approved Sellers</span>
                        <span class="fs-20 fw-700 text-dark">10</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white p-3 rounded-2 shadow-sm border border-gray-200">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-md mr-3 bg-soft-warning text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="las la-clock fs-24"></i>
                    </span>
                    <div>
                        <span class="fs-12 text-muted d-block uppercase fw-600">Pending Approval</span>
                        <span class="fs-20 fw-700 text-dark">2</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white p-3 rounded-2 shadow-sm border border-gray-200">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-md mr-3 bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="las la-dollar-sign fs-24"></i>
                    </span>
                    <div>
                        <span class="fs-12 text-muted d-block uppercase fw-600">Total Due to Sellers</span>
                        <span class="fs-20 fw-700 text-dark">$3,840.50</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom-0 pb-0 d-block d-md-flex align-items-center justify-content-between">
            <h5 class="mb-2 mb-md-0 h6 font-weight-bold">Sellers Directory</h5>
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm mr-2" style="width: 280px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0"><i class="las la-search text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0" id="sellerSearchInput" placeholder="Type shop name, email & hit enter">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="40">
                                <label class="aiz-checkbox mb-0">
                                    <input type="checkbox" id="checkAllSellers">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </th>
                            <th>Shop Name</th>
                            <th>Phone</th>
                            <th>Email Address</th>
                            <th>Verification</th>
                            <th>Num of Products</th>
                            <th>Due to Seller</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="sellerTableBody">
                        <?php 
                        $sellerList = !empty($sellers) ? $sellers : [
                            ['id' => 1, 'name' => 'Fashion Digital Hub', 'owner' => 'Rahim Chowdhury', 'email' => 'fashion.hub@example.com', 'phone' => '+8801711111111', 'products' => 45, 'due' => 1250.00, 'verified' => 1, 'banned' => 0],
                            ['id' => 2, 'name' => 'Electro World Store', 'owner' => 'Karim Uddin', 'email' => 'electroworld@example.com', 'phone' => '+8801822222222', 'products' => 88, 'due' => 890.50, 'verified' => 1, 'banned' => 0],
                            ['id' => 3, 'name' => 'Organic Food Corner', 'owner' => 'Selim Hossain', 'email' => 'organic@example.com', 'phone' => '+8801933333333', 'products' => 12, 'due' => 340.00, 'verified' => 0, 'banned' => 0],
                            ['id' => 4, 'name' => 'Smart Gadgets Zone', 'owner' => 'Tanvir Ahmed', 'email' => 'gadgets@example.com', 'phone' => '+8801744444444', 'products' => 34, 'due' => 1360.00, 'verified' => 1, 'banned' => 0],
                        ];
                        foreach ($sellerList as $seller): 
                        ?>
                        <tr class="seller-row" id="seller_row_<?= $seller['id'] ?>" data-search="<?= strtolower(esc(($seller['name'] ?? '').' '.($seller['email'] ?? ''))) ?>">
                            <td>
                                <label class="aiz-checkbox mb-0">
                                    <input type="checkbox" class="check-one-seller" value="<?= $seller['id'] ?>">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm mr-2 bg-soft-primary text-primary font-weight-bold rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                        <?= strtoupper(substr($seller['name'] ?? 'S', 0, 1)) ?>
                                    </span>
                                    <div>
                                        <div class="font-weight-bold text-dark"><?= esc($seller['name'] ?? 'N/A') ?></div>
                                        <small class="text-muted">Owner: <?= esc($seller['owner'] ?? 'Seller') ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($seller['phone'] ?? 'N/A') ?></td>
                            <td><?= esc($seller['email'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (($seller['verified'] ?? 0) == 1): ?>
                                    <span class="badge badge-inline badge-soft-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-soft-warning">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-600"><?= esc($seller['products'] ?? 0) ?></td>
                            <td class="fw-700 text-success">$<?= number_format($seller['due'] ?? 0, 2) ?></td>
                            <td class="text-right">
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm btn-pay" href="javascript:void(0);" data-id="<?= $seller['id'] ?>" data-name="<?= esc($seller['name'] ?? '') ?>" data-due="<?= number_format($seller['due'] ?? 0, 2) ?>" title="Pay to Seller">
                                    <i class="las la-dollar-sign"></i>
                                </a>
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm btn-login" href="javascript:void(0);" data-name="<?= esc($seller['name'] ?? '') ?>" title="Log in as seller">
                                    <i class="las la-sign-in-alt"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit" href="javascript:void(0);">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-seller" data-id="<?= $seller['id'] ?>" title="Ban / Delete Seller" href="javascript:void(0);">
                                    <i class="las la-ban"></i>
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

<!-- Modal: Add New Seller -->
<div class="modal fade" id="addSellerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Add New Seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Shop Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Shop Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Owner Name</label>
                        <input type="text" class="form-control" name="owner" placeholder="Owner Full Name">
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="seller@example.com" required>
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
                    <button type="submit" class="btn btn-primary font-weight-bold">Create Seller</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Pay to Seller -->
<div class="modal fade" id="paySellerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-weight-bold">Pay to Seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="paySellerForm">
                <div class="modal-body">
                    <p class="fs-14 mb-3">Payment for: <strong id="pay_seller_name" class="text-primary">Shop Name</strong></p>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Current Due Amount</label>
                        <input type="text" class="form-control bg-light" id="pay_seller_due" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Pay Amount ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" class="form-control" name="amount" id="pay_amount" placeholder="0.00" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Payment Option</label>
                        <select class="form-control" name="payment_option">
                            <option value="cash">Cash Payment</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold">Complete Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('sellerSearchInput');
    const rows = document.querySelectorAll('.seller-row');

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

    const checkAll = document.getElementById('checkAllSellers');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            document.querySelectorAll('.check-one-seller').forEach(cb => cb.checked = this.checked);
        });
    }

    document.querySelectorAll('.btn-pay').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = this.getAttribute('data-name');
            const due = this.getAttribute('data-due');
            document.getElementById('pay_seller_name').innerText = name;
            document.getElementById('pay_seller_due').value = '$' + due;
            document.getElementById('pay_amount').value = due;
            $('#paySellerModal').modal('show');
        });
    });

    document.querySelectorAll('.btn-login').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Logging in as seller: ' + this.getAttribute('data-name'));
        });
    });

    document.querySelectorAll('.btn-delete-seller').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to ban / delete this seller?')) {
                const row = document.getElementById('seller_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
