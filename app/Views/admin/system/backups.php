<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Database Backup & Restore</h1>
            <span class="fs-13 text-muted">Create system database backups, check file permissions, and restore previous backups</span>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0)" class="btn btn-primary rounded-2 px-3 mr-2" data-toggle="modal" data-target="#createBackupModal">
                <i class="las la-archive mr-1 fs-16"></i> Create Database Backup
            </a>
            <a href="javascript:void(0)" class="btn btn-soft-info rounded-2 px-3" data-toggle="modal" data-target="#checkPermissionModal">
                <i class="las la-check-circle mr-1 fs-16"></i> Check Permissions
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <!-- Informational Alert -->
    <div class="alert alert-info rounded-2 border-0 shadow-sm mb-4">
        <div class="d-flex align-items-center">
            <i class="las la-database fs-24 mr-3 text-info"></i>
            <div>
                <strong>Automatic Backup Management:</strong> Regular backups safeguard your product catalog, orders, and customer data. Backups are stored securely under <code>writable/backups/</code>.
            </div>
        </div>
    </div>

    <!-- Backups Table -->
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Existing System Backups</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Created Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $backups = [
                            ['id' => 1, 'name' => 'db_backup_2026_10_07_full.sql.gz', 'size' => '14.2 MB', 'date' => '2026-10-07 23:45:00'],
                            ['id' => 2, 'name' => 'db_backup_2026_10_01_full.sql.gz', 'size' => '13.8 MB', 'date' => '2026-10-01 12:30:15'],
                            ['id' => 3, 'name' => 'db_backup_2026_09_15_full.sql.gz', 'size' => '12.5 MB', 'date' => '2026-09-15 09:10:00'],
                        ];
                        foreach ($backups as $index => $b):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark">
                                <i class="las la-file-archive text-primary fs-18 mr-2"></i>
                                <?= esc($b['name']) ?>
                            </td>
                            <td><?= esc($b['size']) ?></td>
                            <td><?= esc($b['date']) ?></td>
                            <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-soft-success btn-icon btn-circle btn-sm mr-1" title="Download">
                                    <i class="las la-download"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm mr-1" title="Restore Database">
                                    <i class="las la-undo-alt"></i>
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

<!-- Create Backup Modal -->
<div class="modal fade" id="createBackupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Create New Database Backup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/system/backup/create') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="fs-14 text-secondary mb-3">Creating a new database dump will bundle all current SQL tables into a compressed <code>.sql.gz</code> file.</p>
                    <div class="form-group mb-0">
                        <label class="aiz-checkbox">
                            <input type="checkbox" name="include_uploads" value="1">
                            <span class="fs-13">Include public media uploads folder (zip archive)</span>
                            <span class="aiz-square-check"></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-2" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4">Start Backup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Check Permission Modal -->
<div class="modal fade" id="checkPermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Directory Permissions Check</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <code>writable/backups/</code>
                        <span class="badge badge-success badge-inline">Writable (775)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <code>public/uploads/</code>
                        <span class="badge badge-success badge-inline">Writable (775)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <code>writable/cache/</code>
                        <span class="badge badge-success badge-inline">Writable (775)</span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary rounded-2 px-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
