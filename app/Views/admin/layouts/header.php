<?php
$settingModel = new \App\Models\SettingModel();
$headerAdminLogo = $settingModel->getSetting('admin_logo', 'assets/img/logo.png');
$headerSiteFavicon = $settingModel->getSetting('site_favicon', 'assets/img/logo.png');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= esc($page_title ?? 'Dashboard') ?> | <?= esc($site_name ?? 'NUR-LAB ECOM') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url($headerSiteFavicon) ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <!-- aiz core css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/vendors.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/aiz-core.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom-style.css') ?>">

    <!-- Summernote WYSIWYG Editor -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        var AIZ = AIZ || {};
        AIZ.data = {
            csrf: '<?= csrf_hash() ?>',
            appUrl: '<?= base_url() ?>',
            fileBaseUrl: '<?= base_url() ?>'
        };
        AIZ.local = AIZ.local || {
            choose_file: 'Choose File...',
            file_selected: 'File Selected',
            files_selected: 'Files Selected',
            add_more_files: 'Add More Files',
            adding_more_files: 'Adding More Files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload Complete',
            upload_paused: 'Upload Paused',
            resume_upload: 'Resume Upload',
            pause_upload: 'Pause Upload',
            retry_upload: 'Retry Upload',
            cancel_upload: 'Cancel Upload',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete'
        };
    </script>

    <style>
        :root {
            --blue: #3390f3;
            --hov-blue: #1f6dc2;
            --soft-blue: #f1fafd;
            --primary: #009ef7;
            --hov-primary: #008cdd;
            --soft-primary: #f1fafd;
            --secondary: #a1a5b3;
            --soft-secondary: rgba(143, 151, 171, 0.15);
            --success: #19c553;
            --info: #8f60ee;
            --warning: #ffc700;
            --danger: #F0416C;
            --dark: #232734;
            --soft-dark: #1b2133;
        }
        body {
            font-size: 12px;
            font-family: 'Public Sans', sans-serif;
            background-color: #f5f6f9;
        }
        .card {
            border-radius: 8px;
            background: #fff;
            border: 1px solid #f1f1f4;
            box-shadow: 0px 6px 14px rgba(35, 39, 52, 0.04);
        }
        
        /* Sidebar Submenu Styling */
        .aiz-side-nav-list.level-2,
        .aiz-side-nav-list.level-3 {
            display: none;
            padding-left: 0px;
            list-style: none;
        }
        .aiz-side-nav-list.level-2 .aiz-side-nav-link {
            padding: 9px 20px 9px 40px !important;
            font-size: 13px;
        }
        .aiz-side-nav-list.level-3 .aiz-side-nav-link {
            padding: 8px 20px 8px 55px !important;
            font-size: 12px;
        }
        .aiz-side-nav-list.level-2 .aiz-side-nav-link:before {
            content: "";
            display: inline-block;
            width: 7px;
            height: 7px;
            border: 1.5px solid #8f9bba;
            border-radius: 50%;
            margin-right: 12px;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .aiz-side-nav-list.level-3 .aiz-side-nav-link:before {
            content: "";
            display: inline-block;
            width: 5px;
            height: 5px;
            background-color: #8f9bba;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .aiz-side-nav-list.level-2 .aiz-side-nav-link:hover:before,
        .aiz-side-nav-item.mm-active > .aiz-side-nav-link:before {
            border-color: #009ef7;
            background-color: #009ef7;
        }
        .aiz-side-nav-item.mm-active > .aiz-side-nav-list,
        .aiz-side-nav-item.open > .aiz-side-nav-list,
        .aiz-side-nav-list.mm-show {
            display: block !important;
        }
        .aiz-side-nav-item > .aiz-side-nav-link {
            position: relative;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #b5b5c3;
            text-decoration: none;
            cursor: pointer;
        }
        .aiz-side-nav-item > .aiz-side-nav-link:hover,
        .aiz-side-nav-item.mm-active > .aiz-side-nav-link,
        .aiz-side-nav-item.open > .aiz-side-nav-link {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }
        .aiz-side-nav-item.mm-active > .aiz-side-nav-link .aiz-side-nav-arrow::after,
        .aiz-side-nav-item.open > .aiz-side-nav-link .aiz-side-nav-arrow::after {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <div class="aiz-main-wrapper">
        <!-- Sidebar -->
        <div class="aiz-sidebar-wrap">
            <div class="aiz-sidebar left c-scrollbar">
                <div class="aiz-side-nav-logo-wrap py-1 px-3 text-center mb-2">
                    <a href="<?= base_url('admin/dashboard') ?>" class="d-flex align-items-center justify-content-center text-decoration-none">
                        <img src="<?= base_url($headerAdminLogo) ?>" alt="Logo" class="mw-100" style="max-height: 42px; height: 38px; width: auto; object-fit: contain;" onerror="this.src='<?= base_url('assets/img/logo.png') ?>';">
                        <span class="fs-18 fw-800 text-primary" style="display:none;">
                            <i class="las la-shopping-bag mr-1"></i> <?= esc($site_name ?? 'NUR-LAB ECOM') ?>
                        </span>
                    </a>
                </div>

                <div class="aiz-side-nav-wrap">
                    <!-- Search Input -->
                    <div class="px-3 mb-3">
                        <input class="form-control bg-soft-secondary border-0 text-white w-100 py-2 px-3 fs-13" type="text" placeholder="Search in menu" id="menu-search" onkeyup="menuSearch()" style="height: 38px; border-radius: 6px;">
                    </div>

                    <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                        <!-- Dashboard -->
                        <li class="aiz-side-nav-item">
                            <a href="<?= base_url('admin/dashboard') ?>" class="aiz-side-nav-link <?= (uri_string() === 'admin' || uri_string() === 'admin/dashboard') ? 'active' : '' ?>">
                                <i class="las la-home aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- POS System -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-tasks aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">POS System</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/pos') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">POS Manager</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/pos-activation') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">POS Configuration</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Products -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Products</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products/create') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Add New Product</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">All Products</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products/inhouse') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">In House Products</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products/digital') ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Digital Products</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Seller Product</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <li class="aiz-side-nav-item">
                                            <a href="<?= base_url('admin/products/seller-physical') ?>" class="aiz-side-nav-link">
                                                <span class="aiz-side-nav-text">Physical Products</span>
                                            </a>
                                        </li>
                                        <li class="aiz-side-nav-item">
                                            <a href="<?= base_url('admin/products/seller-digital') ?>" class="aiz-side-nav-link">
                                                <span class="aiz-side-nav-text">Digital Products</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products/bulk-import') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Import</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/products/bulk-export') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Export</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/categories') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Category</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/brands') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Brand</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/attributes') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Attribute</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/colors') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Colors</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/product-reviews') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Product Reviews</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/units') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Units</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/warranties') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Warranties</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/size-charts') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Size Charts</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/measurement-points') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Measurement Points</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/custom-labels') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Custom Labels</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/category-wise-discount') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Category Wise Discount</span></a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?= base_url('admin/category-wise-refund') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Category Wise Refund</span></a>
                                </li>
                            </ul>
                        </li>

                        <!-- Auction Products -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-gavel aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Auction Products</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/auction/create') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Add New Auction Product</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/auction/all-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Auction Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/auction/inhouse-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Inhouse Auction Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/auction/seller-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Auction Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/auction/orders') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Auction Products Orders</span></a></li>
                            </ul>
                        </li>

                        <!-- Wholesale Products -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-luggage-cart aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Wholesale Products</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/wholesale/create') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Add New Wholesale Product</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/wholesale/all-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Wholesale Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/wholesale/inhouse-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">In House Wholesale Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/wholesale/seller-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Wholesale Products</span></a></li>
                            </ul>
                        </li>

                        <!-- Sales -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-money-bill aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Sales</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/orders/all') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Orders</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/orders/inhouse') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Inhouse Orders</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/orders/seller') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Orders</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/orders/pickup-point') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Pick-up Point Order</span></a></li>
                            </ul>
                        </li>

                        <!-- Delivery Boy -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-truck aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Delivery Boy</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Delivery Boy</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys/create') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Add Delivery Boy</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys/payments') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Payment Histories</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys/collected') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Collected Histories</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys/cancel-requests') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Cancel Request</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/delivery-boys/config') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Configuration</span></a></li>
                            </ul>
                        </li>

                        <!-- Refunds -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Refunds</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/refunds/requests') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Refund Requests</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/refunds/approved') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Approved Refunds</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/refunds/rejected') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Rejected Refunds</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/refunds/config') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Refund Configuration</span></a></li>
                            </ul>
                        </li>

                        <!-- Customers -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-user-friends aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Customers</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/customers') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Customer List</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/customers/classified-products') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Classified Products</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/customers/classified-packages') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Classified Packages</span></a></li>
                            </ul>
                        </li>

                        <!-- Sellers -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-user aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Sellers</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Seller</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers/payouts') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Payouts</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers/payout-requests') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Payout Requests</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers/commission') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Commission</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers/packages') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Packages</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/sellers/verification-form') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Verification Form</span></a></li>
                            </ul>
                        </li>

                        <!-- Uploaded Files -->
                        <li class="aiz-side-nav-item">
                            <a href="<?= base_url('admin/uploaded-files') ?>" class="aiz-side-nav-link">
                                <i class="las la-folder-open aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Uploaded Files</span>
                            </a>
                        </li>

                        <!-- Reports -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-file-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Reports</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/inhouse-sales') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">In House Product Sale</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/seller-sales') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Seller Products Sale</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/stock') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Products Stock</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/wishlist') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Products wishlist</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/user-searches') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">User Searches</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/commission-history') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Commission History</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/reports/wallet-recharge-history') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Wallet Recharge History</span></a></li>
                            </ul>
                        </li>

                        <!-- Blog System -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-bullhorn aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Blog System</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/blog') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All Posts</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/blog/categories') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Categories</span></a></li>
                            </ul>
                        </li>

                        <!-- Marketing -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-bullhorn aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Marketing</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/marketing/flash-deals') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Flash deals</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/marketing/newsletters') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Newsletters</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/marketing/subscribers') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Subscribers</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/marketing/coupons') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Coupon</span></a></li>
                            </ul>
                        </li>

                        <!-- Support -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-link aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Support</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/support/tickets') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Ticket</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/support/queries') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Product Queries</span></a></li>
                            </ul>
                        </li>

                        <!-- Website Setup -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-desktop aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Website Setup</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/website/header') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Header</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/website/footer') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Footer</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/website/pages') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Pages</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/website/appearance') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Appearance</span></a></li>
                            </ul>
                        </li>

                        <!-- Setup & Configurations -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Setup & Configurations</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/settings') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">General Settings</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/features') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Features activation</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/languages') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Languages</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/currencies') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Currency</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/vat-tax') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Vat & TAX</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/pickup-point') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Pickup point</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/smtp') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">SMTP Settings</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/payment-methods') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Payment Methods</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/order-config') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Order Configuration</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/file-system') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">File System & Cache Configuration</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/social-logins') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Social media Logins</span></a></li>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Facebook</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/facebook/chat') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Facebook Chat</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/facebook/comment') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Facebook Comment</span></a></li>
                                    </ul>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Google</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/google/analytics') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Google Analytics</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/google/recaptcha') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Google Recaptcha</span></a></li>
                                    </ul>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Shipping</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/configuration') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping Configuration</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/countries') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping Countries</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/states') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping States</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/cities') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping Cities</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/zones') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping Zones</span></a></li>
                                        <li class="aiz-side-nav-item"><a href="<?= base_url('admin/setup/shipping/carriers') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Shipping Carrier</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- Staffs -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-user-tie aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">Staffs</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/staff') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">All staffs</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/staff/roles') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Staff permissions</span></a></li>
                            </ul>
                        </li>

                        <!-- System -->
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <i class="las la-cog aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">System</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/system/update') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Update</span></a></li>
                                <li class="aiz-side-nav-item"><a href="<?= base_url('admin/system/server-status') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Server status</span></a></li>
                            </ul>
                        </li>

                        <!-- backup and restore -->
                        <li class="aiz-side-nav-item">
                            <a href="<?= base_url('admin/system/backups') ?>" class="aiz-side-nav-link">
                                <i class="las la-database aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">backup and restore</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="aiz-content-wrapper bg-white">
            <!-- Topbar -->
            <div class="aiz-topbar px-15px px-lg-25px d-flex align-items-center justify-content-between border-bottom py-2" style="height: 60px;">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-topbar p-0 mr-3 d-lg-none" data-toggle="aiz-mobile-nav">
                        <i class="las la-bars fs-24"></i>
                    </button>
                    
                    <div class="d-flex align-items-center ml-2">
                        <div class="dropdown mr-4">
                            <button class="btn btn-dark rounded-pill px-3 py-1 fw-600 fs-13 d-flex align-items-center shadow-sm" type="button" data-toggle="dropdown">
                                Quick Menu <i class="las la-angle-down ml-2 fs-11"></i>
                            </button>
                            <div class="dropdown-menu shadow-sm border-0 mt-2">
                                <a class="dropdown-item" href="<?= base_url('admin/products/create') ?>">Add New Product</a>
                                <a class="dropdown-item" href="<?= base_url('admin/setup/shipping/configuration') ?>">Shipping Setup</a>
                            </div>
                        </div>
                        <a href="<?= base_url('admin/dashboard') ?>" class="text-secondary fw-600 px-3 fs-14 text-decoration-none">Dashboard</a>
                        <a href="<?= base_url('admin/orders') ?>" class="text-secondary fw-600 px-3 fs-14 text-decoration-none">Sales</a>
                        <a href="<?= base_url('admin/reports/seller-sales') ?>" class="text-secondary fw-600 px-3 fs-14 text-decoration-none">Earnings</a>
                        <a href="<?= base_url('admin/website/appearance') ?>" class="text-secondary fw-600 px-3 fs-14 text-decoration-none">Design Studio</a>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-light rounded-pill fw-600 px-3 py-1 mr-3 fs-13 d-flex align-items-center" style="background-color: #f1f5f9; border:none; color: #475569;">
                        <i class="las la-plus mr-1"></i> Add New
                    </a>
                    <a href="<?= base_url() ?>" target="_blank" class="btn btn-light btn-circle btn-sm mr-2 shadow-none bg-transparent" title="Browse Website">
                        <i class="las la-globe fs-20 text-secondary"></i>
                    </a>
                    <a href="<?= base_url('admin/clear-cache') ?>" class="btn btn-light btn-circle btn-sm mr-2 shadow-none bg-transparent" title="Clear Cache">
                        <i class="las la-broom fs-20 text-secondary"></i>
                    </a>
                    <a href="<?= base_url('admin/orders') ?>" class="btn btn-light btn-circle btn-sm mr-2 shadow-none bg-transparent" title="Notifications">
                        <i class="las la-bell fs-20 text-secondary"></i>
                    </a>
                    <a href="<?= base_url('admin/support/tickets') ?>" class="btn btn-light btn-circle btn-sm mr-3 shadow-none" style="background-color: #1e293b; color: white;" title="Messages">
                        <i class="las la-comment fs-20"></i>
                    </a>
                    <div class="dropdown">
                        <button class="btn p-0 border-0 dropdown-toggle no-arrow d-flex align-items-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none; box-shadow: none;">
                            <span class="size-35px rounded-circle bg-light d-flex align-items-center justify-content-center fw-700" style="border: 2px solid #3b82f6;">
                                <i class="las la-user fs-20 text-secondary"></i>
                            </span>
                            <i class="las la-angle-down ml-1 text-secondary fs-12"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm mt-2 border-0 py-2" style="min-width: 150px;">
                            <a class="dropdown-item fs-13 py-2 text-secondary" href="<?= base_url('admin/profile') ?>"><i class="las la-user-circle mr-2 fs-16"></i> Profile</a>
                            <a class="dropdown-item fs-13 py-2 text-secondary" href="<?= base_url('user/logout') ?>"><i class="las la-sign-out-alt mr-2 fs-16"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Body Content -->
            <div class="aiz-main-content p-4">
