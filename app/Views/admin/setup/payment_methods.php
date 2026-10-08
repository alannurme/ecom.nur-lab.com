<?= $this->include('admin/layouts/header') ?>

<style>
    .payment-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid rgba(0,0,0,0.05) !important;
        background: #ffffff;
        border-radius: 16px !important;
        overflow: hidden;
    }
    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
        border-color: rgba(0,0,0,0.1) !important;
    }
    .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(var(--primary-rgb, 45, 106, 255), 0.1) 0%, rgba(var(--primary-rgb, 45, 106, 255), 0.05) 100%);
    }
    .icon-wrapper.success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.05) 100%);
    }
    .icon-wrapper.primary {
        background: linear-gradient(135deg, rgba(45, 106, 255, 0.15) 0%, rgba(45, 106, 255, 0.05) 100%);
    }
    .status-badge {
        font-weight: 600;
        letter-spacing: 0.3px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
    }
    .config-btn {
        transition: all 0.2s ease;
        background: rgba(45, 106, 255, 0.08);
        color: #2d6aff;
        border: none;
        font-weight: 600;
        border-radius: 8px !important;
        padding: 8px 16px;
    }
    .config-btn:hover {
        background: #2d6aff;
        color: #ffffff;
        transform: scale(1.02);
    }
    .premium-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    .premium-modal .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        background: #f8f9fa;
        border-radius: 20px 20px 0 0;
        padding: 20px 25px;
    }
    .premium-modal .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.2s;
    }
    .premium-modal .form-control:focus {
        border-color: #2d6aff;
        box-shadow: 0 0 0 3px rgba(45, 106, 255, 0.15);
    }
</style>

<div class="aiz-titlebar text-left mt-2 mb-4 px-3 px-md-2rem">
    <div class="d-flex align-items-center">
        <div class="mr-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #2d6aff 0%, #00d2ff 100%); color: white;">
            <i class="las la-wallet fs-24"></i>
        </div>
        <div>
            <h1 class="h3 fw-700 mb-1" style="color: #1e293b;">Payment Methods</h1>
            <span class="fs-14 text-muted">Manage available payment options and configure APIs for your store.</span>
        </div>
    </div>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="row">
        <!-- COD Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card payment-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper success mr-3">
                            <i class="las la-money-bill-wave fs-24 text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-700 fs-16 text-dark mb-1">Cash On Delivery</h6>
                            <span class="fs-12 text-muted">Offline Payment</span>
                        </div>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0" data-toggle="tooltip" title="Enable/Disable COD">
                        <input type="checkbox" onchange="togglePaymentMethod('cash_on_delivery', this.checked)" <?= (!empty($payment_methods['cash_on_delivery']) && $payment_methods['cash_on_delivery'] == 1) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                
                <div class="mt-auto pt-3 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge status-badge <?= (!empty($payment_methods['cash_on_delivery']) && $payment_methods['cash_on_delivery'] == 1) ? 'bg-soft-success text-success' : 'bg-soft-secondary text-muted' ?>">
                            <i class="las <?= (!empty($payment_methods['cash_on_delivery']) && $payment_methods['cash_on_delivery'] == 1) ? 'la-check-circle' : 'la-times-circle' ?> mr-1"></i> 
                            <?= (!empty($payment_methods['cash_on_delivery']) && $payment_methods['cash_on_delivery'] == 1) ? 'Active' : 'Disabled' ?>
                        </span>
                        <span class="fs-11 text-muted"><i class="las la-info-circle"></i> No config needed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PipraPay Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card payment-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper primary mr-3">
                            <img src="/public/assets/img/cards/piprapay.png" alt="PipraPay" style="max-height: 24px; object-fit: contain;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'las la-credit-card fs-24 text-primary\'></i>';">
                        </div>
                        <div>
                            <h6 class="fw-700 fs-16 text-dark mb-1">PipraPay / Online Payment</h6>
                            <span class="fs-12 text-muted">Digital Payment Gateway</span>
                        </div>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0" data-toggle="tooltip" title="Enable/Disable PipraPay">
                        <input type="checkbox" onchange="togglePaymentMethod('piprapay', this.checked)" <?= (!empty($payment_methods['piprapay']) && $payment_methods['piprapay'] == 1) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center py-3">
                    <span class="fs-13 fw-600 text-dark"><i class="las la-bug text-warning mr-1"></i> Sandbox Mode</span>
                    <label class="aiz-switch aiz-switch-blue mb-0">
                        <input type="checkbox" onchange="togglePaymentMethod('piprapay_sandbox', this.checked)" <?= (!empty($payment_methods['piprapay_sandbox']) && $payment_methods['piprapay_sandbox'] == 1) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                
                <div class="mt-auto pt-3 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                    <div class="row gutters-5">
                        <div class="col-6">
                            <button type="button" class="btn btn-block config-btn" data-toggle="modal" data-target="#piprapayModal">
                                <i class="las la-cog mr-1"></i> Configure
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-block btn-outline-primary" style="border-radius: 8px; font-weight: 600; padding: 8px 16px;" onclick="runPipraPayTest();">
                                <i class="las la-vial mr-1"></i> Test (10 ৳)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PipraPay Modal -->
<div class="modal fade premium-modal" id="piprapayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <div class="icon-wrapper primary mr-3" style="width:40px; height:40px;">
                    <i class="las la-key fs-20 text-primary"></i>
                </div>
                <h5 class="modal-title fw-700 mb-0">PipraPay Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="las la-times"></i></span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('admin/setup/payment-methods/update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group mb-4">
                        <label class="form-label fw-600 text-dark">Payment Method Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="las la-pen"></i></span>
                            </div>
                            <input type="text" name="piprapay_display_title" class="form-control border-left-0 pl-0" value="<?= esc($payment_methods['piprapay_display_title'] ?? 'PipraPay / Online Payment') ?>" placeholder="e.g. bKash / Nagad / Online Payment">
                        </div>
                        <small class="form-text text-muted mt-1"><i class="las la-info-circle"></i> This title will be shown on the checkout page.</small>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label fw-600 text-dark">Base URL</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="las la-link"></i></span>
                            </div>
                            <input type="text" name="piprapay_base_url" class="form-control border-left-0 pl-0" value="<?= esc($payment_methods['piprapay_base_url'] ?? '') ?>" placeholder="e.g. https://pay.nur-lab.com">
                        </div>
                        <small class="form-text text-muted mt-2"><i class="las la-info-circle"></i> Leave empty to use default URL</small>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label fw-600 text-dark">API Key <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="las la-shield-alt"></i></span>
                            </div>
                            <input type="password" name="piprapay_api_key" class="form-control border-left-0 pl-0" value="<?= esc($payment_methods['piprapay_api_key'] ?? '') ?>" placeholder="Enter your secret API Key">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-5">
                        <button type="button" class="btn btn-light rounded-pill px-4 py-2 fw-600 mr-2" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-600 shadow-sm">
                            <i class="las la-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePaymentMethod(key, status) {
    $.ajax({
        url: '<?= base_url('admin/setup/features/update') ?>',
        type: 'POST',
        data: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            key: key,
            status: status ? 1 : 0
        },
        success: function(response) {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify(response.status ? 'success' : 'danger', response.message);
            }
        },
        error: function() {
            if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Error updating payment method status');
            }
        }
    });
}
function runPipraPayTest() {
    $.ajax({
        url: '<?= base_url('admin/setup/payment-methods/test-piprapay') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success' && res.payment_url) {
                if (confirm(res.message + "\nClick OK to open PipraPay gateway payment page.")) {
                    window.open(res.payment_url, '_blank');
                }
            } else if (res.status === 'error') {
                alert('PipraPay Config Notice:\n' + res.message);
            } else {
                alert('PipraPay Configuration:\n' + res.message);
            }
        },
        error: function(err) {
            alert('Failed to connect to PipraPay test endpoint.');
        }
    });
}
</script>

<?= $this->include('admin/layouts/footer') ?>
