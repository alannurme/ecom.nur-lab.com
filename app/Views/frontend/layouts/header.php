<?php
$settingModel = new \App\Models\SettingModel();
$headerSystemLogo = $settingModel->getSetting('system_logo', 'assets/img/logo.png');
$headerSiteFavicon = $settingModel->getSetting('site_favicon', 'assets/img/logo.png');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($site_name ?? 'NUR-LAB ECOM') ?> | Online Shopping in Bangladesh</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url($headerSiteFavicon) ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <!-- CSS Files from Active eCommerce Theme -->
    <link rel="stylesheet" href="<?= base_url('assets/css/vendors.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/aiz-core.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom-style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/metro.css') ?>">
    
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: 'Nothing selected',
            nothing_found: 'Nothing found',
            choose_file: 'Choose file',
            file_selected: 'File selected',
            files_selected: 'Files selected',
            add_more_files: 'Add more files',
            adding_more_files: 'Adding more files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload complete',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete'
        }
    </script>
    
    <style>
        :root {
            --blue: #3490f3;
            --hov-blue: #2e7fd6;
            --soft-blue: rgba(0, 123, 255, 0.15);
            --secondary-base: #ffc519;
            --hov-secondary-base: #dbaa17;
            --soft-secondary-base: rgba(255, 197, 25, 0.15);
            --gray: #9d9da6;
            --gray-dark: #8d8d8d;
            --secondary: #919199;
            --soft-secondary: rgba(145, 145, 153, 0.15);
            --success: #85b567;
            --soft-success: rgba(133, 181, 103, 0.15);
            --warning: #f3af3d;
            --soft-warning: rgba(243, 175, 61, 0.15);
            --light: #f5f5f5;
            --soft-light: #dfdfe6;
            --soft-white: #b5b5bf;
            --dark: #292933;
            --soft-dark: #1b1b28;
            --primary: #ee1c25;
            --hov-primary: #c91119;
            --soft-primary: rgba(238, 28, 37, 0.15);
        }
        body {
            font-family: 'Public Sans', sans-serif;
            font-weight: 400;
            background-color: #f2f4f8;
            color: #292933;
        }
        .aiz-main-wrapper {
            background-color: #f2f4f8 !important;
        }
        .bg-white {
            background-color: #ffffff !important;
        }
        .text-primary {
            color: var(--primary) !important;
        }
        .bg-primary {
            background-color: var(--primary) !important;
        }
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-primary:hover {
            background-color: var(--hov-primary) !important;
            border-color: var(--hov-primary) !important;
        }
        .btn-soft-primary {
            background-color: var(--soft-primary) !important;
            color: var(--primary) !important;
        }
        .badge-primary {
            background-color: var(--primary) !important;
        }
        .hov-text-primary:hover {
            color: var(--primary) !important;
        }
        /* Custom Header Overrides */
        .top-navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #eaeaea;
            font-size: 13px;
        }
        .top-navbar a {
            color: #555555 !important;
            font-weight: 500;
        }
        .top-navbar a:hover {
            color: #ee1c25 !important;
        }
        .category-nav-dropdown .btn {
            background-color: rgba(0, 0, 0, 0.12) !important;
            transition: all 0.2s ease-in-out;
        }
        .category-nav-dropdown .btn:hover {
            background-color: rgba(0, 0, 0, 0.22) !important;
        }
        .nav-link-item {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 14px;
            transition: opacity 0.2s ease;
        }
        .nav-link-item:hover {
            opacity: 0.85;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="aiz-main-wrapper d-flex flex-column bg-white min-vh-100">

    <!-- Top Bar -->
    <div class="top-navbar z-1035 py-1">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Left: Language & Currency -->
                <div class="d-flex align-items-center">
                    <div class="dropdown mr-3">
                        <a href="javascript:void(0)" class="dropdown-toggle text-decoration-none fs-12 text-secondary" data-toggle="dropdown">
                            English
                        </a>
                        <div class="dropdown-menu dropdown-menu-left fs-12 min-w-100px shadow-sm">
                            <a href="javascript:void(0)" class="dropdown-item py-1">English</a>
                            <a href="javascript:void(0)" class="dropdown-item py-1">Bangla</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle text-decoration-none fs-12 text-secondary" data-toggle="dropdown">
                            Taka
                        </a>
                        <div class="dropdown-menu dropdown-menu-left fs-12 min-w-100px shadow-sm">
                            <a href="javascript:void(0)" class="dropdown-item py-1">Taka (৳)</a>
                            <a href="javascript:void(0)" class="dropdown-item py-1">USD ($)</a>
                        </div>
                    </div>
                </div>

                <!-- Right: Seller & Helpline -->
                <div class="d-flex align-items-center fs-12">
                    <div class="dropdown mr-4">
                        <a href="<?= base_url('seller/login') ?>" class="dropdown-toggle text-decoration-none text-secondary">
                            Become a Seller !
                        </a>
                    </div>
                    <div>
                        <span class="text-secondary">Helpline: </span>
                        <a href="tel:+8801621520090" class="text-dark fw-600 text-decoration-none">+8801621-520090</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Logo & Search -->
    <header class="sticky-top z-1020 bg-white border-bottom shadow-sm">
        <div class="position-relative logo-bar-area py-3">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Logo -->
                    <div class="col-auto pl-0 pr-4">
                        <a class="d-block text-decoration-none" href="<?= base_url() ?>">
                            <img src="<?= base_url($headerSystemLogo) ?>" class="mh-45px h-45px max-w-220px" alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                            <span class="fs-24 fw-800 text-danger" style="display:none;">
                                <i class="las la-shopping-bag mr-1"></i> <?= esc($site_name ?? 'NUR-LAB ECOM') ?>
                            </span>
                        </a>
                    </div>

                    <!-- Search Input Box -->
                    <div class="flex-grow-1 front-header-search d-none d-lg-block mx-xl-4">
                        <form action="<?= base_url('products') ?>" method="GET" class="mb-0">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded-pill pl-4 pr-5 fs-14 bg-white" name="keyword" placeholder="I am shopping for..." style="height: 44px; border: 1px solid #cbd5e0;" autocomplete="off">
                                <button type="submit" class="btn position-absolute right-0 top-0 h-100 pr-4 pl-2 text-secondary bg-transparent border-0">
                                    <i class="las la-search fs-20 text-muted"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="d-flex align-items-center justify-content-end col-auto pr-0 pl-3">
                        <?php
                        $session = session();
                        $userSession = $session->get('user');

                        // Fallback: If no session object exists, auto-detect active admin user from db
                        if (empty($userSession) && !$session->get('user_id')) {
                            $dbTemp = \Config\Database::connect();
                            $adminRow = $dbTemp->table('users')->where('user_type', 'admin')->get()->getRowArray();
                            if (!empty($adminRow)) {
                                $userSession = $adminRow;
                            }
                        }

                        $isLoggedIn = !empty($userSession) || $session->get('logged_in') || $session->get('user_id') || $session->get('admin_logged_in');
                        $userName = !empty($userSession['name']) ? $userSession['name'] : ($session->get('user_name') ?? $session->get('name') ?? ($isLoggedIn ? 'Admin' : 'Login'));
                        ?>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none text-dark" data-toggle="dropdown">
                                <span class="size-38px rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center mr-2 border">
                                    <i class="las la-user fs-22 text-secondary"></i>
                                </span>
                                <span class="fw-700 fs-14 text-dark"><?= esc($userName) ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 rounded-2 py-2 mt-2">
                                <?php if ($isLoggedIn): ?>
                                    <a href="<?= base_url('user/dashboard') ?>" class="dropdown-item py-2"><i class="las la-user mr-2 text-primary"></i> My Account</a>
                                    <a href="<?= base_url('admin') ?>" class="dropdown-item py-2"><i class="las la-cog mr-2 text-warning"></i> Admin Panel</a>
                                    <a href="<?= base_url('seller/login') ?>" class="dropdown-item py-2"><i class="las la-store mr-2 text-success"></i> Seller Panel</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?= base_url('logout') ?>" class="dropdown-item py-2 text-danger"><i class="las la-sign-out-alt mr-2"></i> Logout</a>
                                <?php else: ?>
                                    <a href="<?= base_url('user/login') ?>" class="dropdown-item py-2 text-primary"><i class="las la-sign-in-alt mr-2"></i> Login</a>
                                    <a href="<?= base_url('user/register') ?>" class="dropdown-item py-2 text-success"><i class="las la-user-plus mr-2"></i> Registration</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Red Navigation Bar -->
        <div class="navigation-bar shadow-sm" style="background-color: #ee1c25;">
            <div class="container d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <!-- Categories Dropdown Button -->
                    <div class="dropdown category-nav-dropdown">
                        <button class="btn text-white fw-700 py-3 px-4 rounded-0 d-flex align-items-center border-0" type="button" data-toggle="dropdown">
                            <span class="fs-15 font-weight-bold">Categories</span>
                            <span class="fs-11 text-white-50 ml-2 font-weight-normal">(See All)</span>
                            <i class="las la-angle-down ml-3 fs-14"></i>
                        </button>
                        <div class="dropdown-menu border-0 shadow-lg mt-0 py-2" style="min-width: 260px;">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <a class="dropdown-item py-2 px-3 fw-600 text-dark d-flex align-items-center justify-content-between" href="<?= base_url('category/' . esc($cat['slug'])) ?>">
                                        <span>
                                            <?php if (!empty($cat['icon_img'])): ?>
                                                <img src="<?= base_url($cat['icon_img']) ?>" alt="" width="20" height="20" class="mr-2" onerror="this.style.display='none'">
                                            <?php endif; ?>
                                            <?= esc($cat['name']) ?>
                                        </span>
                                        <i class="las la-angle-right fs-12 text-muted"></i>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <a class="dropdown-item py-2 px-3 text-muted" href="<?= base_url('categories') ?>">All Categories</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Nav Links -->
                    <div class="pl-4">
                        <ul class="list-inline mb-0 d-flex align-items-center">
                            <li class="list-inline-item mr-4"><a href="<?= base_url() ?>" class="nav-link-item">Home</a></li>
                            <li class="list-inline-item mr-4"><a href="<?= base_url('products') ?>" class="nav-link-item">Flash Sale</a></li>
                            <li class="list-inline-item mr-4"><a href="<?= base_url('blog') ?>" class="nav-link-item">Blogs</a></li>
                            <li class="list-inline-item mr-4"><a href="<?= base_url('brands') ?>" class="nav-link-item">All Brands</a></li>
                            <li class="list-inline-item mr-4"><a href="<?= base_url('categories') ?>" class="nav-link-item">All categories</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Right Side: Cart Box with Mini Cart Dropdown -->
                <?php
                $headerCart = session()->get('cart') ?? [];
                $headerCartCount = 0;
                $headerCartTotal = 0;
                foreach ($headerCart as $hItem) {
                    $hQty = (int)($hItem['qty'] ?? 1);
                    $headerCartCount += $hQty;
                    $headerCartTotal += ((float)($hItem['price'] ?? 0)) * $hQty;
                }
                ?>
                <div class="cart-box-nav position-relative dropdown" id="cart-dropdown-box">
                    <a href="javascript:void(0)" id="cart-dropdown-toggle" class="text-white text-decoration-none d-flex align-items-center py-2 px-3 fw-700 fs-14 dropdown-toggle no-arrow" data-toggle="dropdown" aria-expanded="false" style="background-color: rgba(0, 0, 0, 0.18); border-radius: 6px; cursor: pointer; transition: background-color 0.2s;">
                        <i class="las la-shopping-cart fs-22 mr-2"></i>
                        <span class="mr-1 cart-total">৳<?= number_format($headerCartTotal, 2) ?></span>
                        <span class="fs-12 text-white-50 font-weight-normal">(<span class="cart-count"><?= $headerCartCount ?></span> Items)</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right p-0 border-0 shadow-lg" style="min-width: 380px; width: 400px; max-width: 95vw; border-radius: 14px; overflow: hidden; margin-top: 10px; border: 1px solid rgba(0,0,0,0.08) !important;">
                        <!-- Header -->
                        <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="las la-shopping-cart text-primary fs-22 mr-2"></i>
                                <h6 class="fw-800 fs-15 text-dark mb-0" style="color: #0f172a !important;">My Shopping Cart</h6>
                            </div>
                            <span class="badge badge-inline bg-soft-primary text-primary fs-12 fw-700 px-3 py-1-5 border" style="font-size: 12px; font-weight: 700; white-space: nowrap; border-radius: 20px;"><span class="cart-count mr-1"><?= $headerCartCount ?></span> Items</span>
                        </div>

                        <!-- Item List -->
                        <div class="cart-items-list" style="max-height: 320px; overflow-y: auto; scrollbar-width: thin;">
                            <?php if (!empty($headerCart)): ?>
                                <ul class="list-group list-group-flush mb-0">
                                    <?php foreach ($headerCart as $cKey => $cItem): ?>
                                        <li class="list-group-item px-3 py-3 d-flex align-items-center justify-content-between border-bottom-light" style="transition: background-color 0.15s; background-color: #fff;">
                                            <div class="d-flex align-items-center overflow-hidden mr-2" style="flex: 1;">
                                                <img src="<?= !empty($cItem['thumbnail']) ? base_url($cItem['thumbnail']) : base_url('assets/img/placeholder.jpg') ?>" 
                                                     alt="" width="48" height="48" class="rounded border mr-2 flex-shrink-0" style="object-fit: cover; border-color: #e2e8f0 !important;"
                                                     onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                                <div class="overflow-hidden">
                                                    <h6 class="fs-13 fw-700 mb-1 text-dark text-truncate" style="color: #1e293b !important; line-height: 1.2;" title="<?= esc($cItem['name']) ?>"><?= esc($cItem['name']) ?></h6>
                                                    <div class="d-flex align-items-center fs-12">
                                                        <span class="fw-700 text-primary mr-2">৳<?= number_format($cItem['price'], 2) ?></span>
                                                        <div class="input-group input-group-sm rounded border align-items-center bg-light" style="width: 85px;">
                                                            <div class="input-group-prepend"><button class="btn btn-xs text-dark px-1.5 border-0" onclick="updateCartQtyDirect(<?= $cKey ?>, 'decrease', event)"><i class="las la-minus fs-10"></i></button></div>
                                                            <span class="form-control form-control-sm text-center border-0 px-0 bg-transparent fw-700 fs-11" style="height: auto; padding: 2px 0;"><?= $cItem['qty'] ?></span>
                                                            <div class="input-group-append"><button class="btn btn-xs text-dark px-1.5 border-0" onclick="updateCartQtyDirect(<?= $cKey ?>, 'increase', event)"><i class="las la-plus fs-10"></i></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" onclick="removeFromCartDirect(<?= $cKey ?>, event)" class="text-danger p-1 rounded-circle hover-bg-light flex-shrink-0 d-flex align-items-center justify-content-center ml-1" style="width: 28px; height: 28px; text-decoration: none;" title="Remove">
                                                <i class="las la-trash-alt fs-16"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="text-center py-5 px-4">
                                    <div class="mb-3 d-inline-block p-3 rounded-circle bg-light text-muted">
                                        <i class="las la-shopping-basket fs-40" style="color: #94a3b8;"></i>
                                    </div>
                                    <h6 class="fs-15 fw-700 text-dark mb-1" style="color: #1e293b !important;">Your cart is empty</h6>
                                    <p class="fs-13 text-muted mb-0">Add products to your cart to see them here.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer Subtotal & Action Buttons -->
                        <div id="cart-footer-box" class="p-4 bg-light border-top <?= empty($headerCart) ? 'd-none' : '' ?>" style="background-color: #f8fafc !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-secondary fw-700 fs-14" style="color: #475569 !important;">Subtotal:</span>
                                <span class="fw-800 text-primary fs-18 cart-total" style="color: #e62e04 !important;">৳<?= number_format($headerCartTotal, 2) ?></span>
                            </div>
                            <div class="row gutters-10">
                                <div class="col-6">
                                    <a href="<?= base_url('cart') ?>" class="btn btn-outline-primary btn-block fw-700 py-2.5 fs-13" style="border-radius: 8px; border-width: 2px;">View Cart</a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-block fw-700 py-2.5 fs-13 shadow-sm" style="border-radius: 8px; background-color: #e62e04; border-color: #e62e04;">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
