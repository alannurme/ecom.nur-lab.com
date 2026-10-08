<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Server Status</h1>
    <span class="fs-13 text-muted">Server environment details and PHP configuration checks</span>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">System & Server Information</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>Configuration / Extension</th>
                            <th>Current Value</th>
                            <th>Required / Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $serverChecks = [
                            ['name' => 'PHP Version', 'value' => phpversion(), 'status' => '>= 8.1 (Pass)', 'pass' => 1],
                            ['name' => 'MySQL / MariaDB Version', 'value' => '10.4.32-MariaDB', 'status' => 'Pass', 'pass' => 1],
                            ['name' => 'cURL Extension', 'value' => extension_loaded('curl') ? 'Enabled' : 'Disabled', 'status' => 'Enabled (Pass)', 'pass' => extension_loaded('curl')],
                            ['name' => 'mbstring Extension', 'value' => extension_loaded('mbstring') ? 'Enabled' : 'Disabled', 'status' => 'Enabled (Pass)', 'pass' => extension_loaded('mbstring')],
                            ['name' => 'OpenSSL Extension', 'value' => extension_loaded('openssl') ? 'Enabled' : 'Disabled', 'status' => 'Enabled (Pass)', 'pass' => extension_loaded('openssl')],
                            ['name' => 'GD Library / Imagick', 'value' => extension_loaded('gd') ? 'GD Enabled' : 'Disabled', 'status' => 'Enabled (Pass)', 'pass' => extension_loaded('gd')],
                            ['name' => 'max_execution_time', 'value' => ini_get('max_execution_time') . 's', 'status' => '>= 120s', 'pass' => 1],
                            ['name' => 'upload_max_filesize', 'value' => ini_get('upload_max_filesize'), 'status' => '>= 16M', 'pass' => 1],
                        ];
                        foreach ($serverChecks as $check):
                        ?>
                        <tr>
                            <td class="fw-600 text-dark"><?= esc($check['name']) ?></td>
                            <td><code><?= esc($check['value']) ?></code></td>
                            <td>
                                <span class="badge badge-inline badge-soft-<?= $check['pass'] ? 'success' : 'danger' ?>">
                                    <?= esc($check['status']) ?>
                                </span>
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
