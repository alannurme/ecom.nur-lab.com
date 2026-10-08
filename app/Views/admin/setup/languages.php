<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Language Settings</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0)" class="btn btn-primary rounded-2 px-3" data-toggle="modal" data-target="#addLanguageModal">
                <i class="las la-plus mr-1"></i> Add New Language
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Installed Languages</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-light text-secondary fs-12 uppercase">
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>RTL</th>
                            <th>Default</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $languages = [
                            ['id' => 1, 'name' => 'English', 'code' => 'en', 'rtl' => 0, 'default' => 1],
                            ['id' => 2, 'name' => 'Bangla', 'code' => 'bn', 'rtl' => 0, 'default' => 0],
                            ['id' => 3, 'name' => 'Arabic', 'code' => 'sa', 'rtl' => 1, 'default' => 0],
                        ];
                        foreach ($languages as $index => $lang):
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-600 text-dark"><?= esc($lang['name']) ?></td>
                            <td><code><?= esc($lang['code']) ?></code></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" <?= $lang['rtl'] ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <?php if ($lang['default']): ?>
                                    <span class="badge badge-inline badge-success">Default</span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-soft-secondary">Secondary</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <a href="#" class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1" title="Translations">
                                    <i class="las la-language"></i>
                                </a>
                                <?php if (!$lang['default']): ?>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
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

<?= $this->include('admin/layouts/footer') ?>
