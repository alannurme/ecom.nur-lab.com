<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Seller Verification Form</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addFormElementModal" class="btn btn-primary font-weight-bold">
                <i class="las la-plus mr-1"></i> Add Form Element
            </a>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Form Elements List</h5>
        </div>
        <div class="card-body">
            <p class="text-muted fs-14 mb-3">Configure documents & details required from vendors for shop verification approval.</p>
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th>#</th>
                            <th>Label Name</th>
                            <th>Field Type</th>
                            <th>Required Status</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="font-weight-bold text-dark">National ID / Passport Copy</td>
                            <td><span class="badge badge-inline badge-soft-info">File Upload</span></td>
                            <td><span class="badge badge-inline badge-soft-success">Required</span></td>
                            <td class="text-right">
                                <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm"><i class="las la-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="font-weight-bold text-dark">Trade License Number</td>
                            <td><span class="badge badge-inline badge-soft-secondary">Text Input</span></td>
                            <td><span class="badge badge-inline badge-soft-success">Required</span></td>
                            <td class="text-right">
                                <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm"><i class="las la-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="font-weight-bold text-dark">Bank Account Certificate</td>
                            <td><span class="badge badge-inline badge-soft-info">File Upload</span></td>
                            <td><span class="badge badge-inline badge-soft-warning">Optional</span></td>
                            <td class="text-right">
                                <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm"><i class="las la-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Form Element -->
<div class="modal fade" id="addFormElementModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold">Add Form Element</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Label Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="label" placeholder="e.g. NID Copy, Trade License" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-from-label fs-14 fw-500">Field Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="type">
                            <option value="text">Text Input</option>
                            <option value="file">File Upload</option>
                            <option value="select">Dropdown Select</option>
                            <option value="radio">Radio Buttons</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-from-label fs-14 fw-500">Is Required?</label>
                        <select class="form-control" name="is_required">
                            <option value="1">Yes (Mandatory)</option>
                            <option value="0">No (Optional)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Add Element</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
