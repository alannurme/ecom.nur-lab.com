<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Send Newsletter</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-2">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 h6 font-weight-bold">Compose & Broadcast Newsletter</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="form-group mb-3">
                            <label class="col-from-label fs-14 fw-500">Send Emails To <span class="text-danger">*</span></label>
                            <select class="form-control aiz-selectpicker" name="recipient_group" required>
                                <option value="all_customers">All Registered Customers</option>
                                <option value="all_subscribers">All Newsletter Subscribers</option>
                                <option value="all_sellers">All Sellers / Vendors</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="col-from-label fs-14 fw-500">Email Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subject" placeholder="Newsletter Subject" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-from-label fs-14 fw-500">Newsletter Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="content" rows="8" placeholder="Type newsletter body message here..." required></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4">
                                <i class="las la-paper-plane mr-1"></i> Send Newsletter Broadcast
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layouts/footer') ?>
