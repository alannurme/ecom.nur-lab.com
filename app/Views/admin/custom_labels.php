<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">Custom Labels</h1>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0);" class="btn btn-circle btn-info">
                <span>Add Custom Label</span>
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Custom Labels List</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Text Color</th>
                        <th>Background Color</th>
                        <th class="text-right">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><span class="badge badge-inline p-2" style="background:#0099ff;color:#fff;">New Arrival</span></td>
                        <td>#ffffff</td>
                        <td>#0099ff</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#" title="Edit">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" title="Delete">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
