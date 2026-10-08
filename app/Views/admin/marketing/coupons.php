<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">All Coupons</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#createCouponModal" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Create New Coupon
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Coupons Directory</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchCouponInput" placeholder="Search coupon code...">
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
                            <th>Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="couponTableBody">
                        <?php 
                        $couponList = !empty($coupons) ? $coupons : [
                            ['id' => 1, 'code' => 'WINTER20', 'type' => 'For Products', 'discount' => '20%', 'start' => '2026-10-01', 'end' => '2026-10-31'],
                            ['id' => 2, 'code' => 'FLAT50', 'type' => 'For Total Order', 'discount' => '$50.00', 'start' => '2026-10-05', 'end' => '2026-11-05'],
                            ['id' => 3, 'code' => 'WELCOME10', 'type' => 'Welcome Coupon', 'discount' => '10%', 'start' => '2026-01-01', 'end' => '2026-12-31'],
                        ];
                        foreach ($couponList as $index => $c): 
                        ?>
                        <tr class="coupon-row" id="coupon_row_<?= $c['id'] ?>" data-search="<?= strtolower(esc($c['code'] ?? '')) ?>">
                            <td><?= $index + 1 ?></td>
                            <td><span class="badge badge-inline badge-soft-primary font-weight-bold fs-14 px-3 py-1"><?= esc($c['code'] ?? '') ?></span></td>
                            <td><?= esc($c['type'] ?? '') ?></td>
                            <td><span class="fw-700 text-success"><?= esc($c['discount'] ?? '') ?></span></td>
                            <td><?= esc($c['start'] ?? '') ?></td>
                            <td><?= esc($c['end'] ?? '') ?></td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="Edit" href="javascript:void(0);">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm btn-delete-coupon" data-id="<?= $c['id'] ?>" title="Delete" href="javascript:void(0);">
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

<!-- Modal: Create Coupon -->
<div class="modal fade" id="createCouponModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Create New Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Coupon Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" required>
                            <option value="product_base">For Products</option>
                            <option value="cart_base">For Total Order</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" placeholder="e.g. SAVE20" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Discount Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control" name="discount" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-from-label fs-14 fw-500">Discount Type</label>
                            <select class="form-control" name="discount_type">
                                <option value="percent">Percent (%)</option>
                                <option value="amount">Flat Amount ($)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-0">
                            <label class="col-from-label fs-14 fw-500">Start Date</label>
                            <input type="date" class="form-control" name="start_date">
                        </div>
                        <div class="col-md-6 mb-0">
                            <label class="col-from-label fs-14 fw-500">End Date</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCouponInput');
    const rows = document.querySelectorAll('.coupon-row');

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

    document.querySelectorAll('.btn-delete-coupon').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this coupon?')) {
                const row = document.getElementById('coupon_row_' + id);
                if (row) row.remove();
            }
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
