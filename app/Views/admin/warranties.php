<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3 fw-700">All Warranties</h1>
        </div>
        <div class="col text-right">
            <a href="javascript:void(0);" class="btn btn-circle btn-info">
                <span>Add New Warranty</span>
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem">
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">Warranties List</h5>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search Warranties...">
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Text</th>
                        <th>Logo</th>
                        <th class="text-right">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1 Year Brand Warranty</td>
                        <td><span class="badge badge-inline badge-soft-info">Default Logo</span></td>
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
