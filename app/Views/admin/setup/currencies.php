<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Currency Setup</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0)" class="btn btn-primary rounded-2 px-3">
                <i class="las la-plus mr-1"></i> Add New Currency
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">All Currencies</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>Currency Name</th>
                            <th>Symbol</th>
                            <th>Code</th>
                            <th>Exchange Rate (1 USD = ?)</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currencies = [
                            ['id' => 1, 'name' => 'US Dollar', 'symbol' => '$', 'code' => 'USD', 'rate' => 1.00, 'status' => 1],
                            ['id' => 2, 'name' => 'Bangladeshi Taka', 'symbol' => '৳', 'code' => 'BDT', 'rate' => 118.50, 'status' => 1],
                            ['id' => 3, 'name' => 'Euro', 'symbol' => '€', 'code' => 'EUR', 'rate' => 0.92, 'status' => 1],
                        ];
                        foreach ($currencies as $index => $curr):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark"><?= esc($curr['name']) ?></td>
                            <td class="fw-700"><?= esc($curr['symbol']) ?></td>
                            <td><code><?= esc($curr['code']) ?></code></td>
                            <td><?= number_format($curr['rate'], 2) ?></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" <?= $curr['status'] ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Edit">
                                    <i class="las la-pen"></i>
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

<?= $this->include('admin/layouts/footer') ?>
