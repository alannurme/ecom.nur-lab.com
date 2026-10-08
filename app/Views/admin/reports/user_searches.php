<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">User Searches Report</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header border-bottom">
            <h5 class="mb-0 h6 font-weight-bold">Top Searched Keywords</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="50">#</th>
                            <th>Search Query Keyword</th>
                            <th>Number of Searches</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="font-weight-bold text-dark">iphone 14 pro</span></td>
                            <td><span class="badge badge-inline badge-soft-info">1,820 Times</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="font-weight-bold text-dark">mens t-shirt</span></td>
                            <td><span class="badge badge-inline badge-soft-info">1,450 Times</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="font-weight-bold text-dark">wireless earbud</span></td>
                            <td><span class="badge badge-inline badge-soft-info">920 Times</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
