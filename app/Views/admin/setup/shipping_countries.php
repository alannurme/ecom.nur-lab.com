<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 fw-700">Shipping Countries</h1>
            <span class="fs-13 text-muted">Manage the countries where you allow shipping</span>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header border-bottom-0 pt-4 pb-2">
            <h5 class="mb-0 fw-700">All Countries</h5>
            <div class="pull-right">
                <form class="" id="sort_country" action="" method="GET">
                    <div class="box-inline pad-rgt pull-left">
                        <div class="input-group">
                            <input type="text" class="form-control" name="sort_country" placeholder="Type country name & Enter" value="<?= htmlspecialchars($sort_country ?? '') ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 aiz-table">
                    <thead>
                        <tr>
                            <th data-breakpoints="lg">#</th>
                            <th>Name</th>
                            <th data-breakpoints="sm">Code</th>
                            <th class="text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($countries)): ?>
                            <?php foreach ($countries as $key => $country): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= htmlspecialchars($country['name']) ?></td>
                                    <td><?= htmlspecialchars($country['code']) ?></td>
                                    <td class="text-right">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" onchange="update_status(this, <?= $country['id'] ?>)" <?= $country['status'] == 1 ? 'checked' : '' ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">No countries found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function update_status(el, id){
        var status = $(el).is(':checked') ? 1 : 0;
        $.post('<?= base_url('admin/setup/shipping/countries/status') ?>', {
            _token: '<?= csrf_hash() ?>', 
            id: id, 
            status: status
        }, function(data){
            if(data == 1){
                alert('Country status updated successfully');
            }
            else{
                alert('Something went wrong');
            }
        });
    }
</script>

<?= $this->include('admin/layouts/footer') ?>
