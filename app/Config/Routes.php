<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Frontend Product Catalog & Search
$routes->get('product/(:segment)', 'Product::detail/$1');
$routes->get('products', 'Product::list');
$routes->get('search', 'Product::list');
$routes->get('categories', 'Category::index');
$routes->get('category/(:segment)', 'Category::show/$1');
$routes->get('brands', 'Brand::index');

// Shopping Cart & Checkout
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::updateQuantity');
$routes->post('cart/remove-ajax', 'Cart::removeAjax');
$routes->get('cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('order-success/(:segment)', 'Checkout::success/$1');

// Customer Authentication & Portal
$routes->get('user/login', 'User::login');
$routes->post('user/login-process', 'User::loginProcess');
$routes->get('user/register', 'User::register');
$routes->post('user/register-process', 'User::registerProcess');
$routes->get('user/dashboard', 'User::dashboard');
$routes->get('user/logout', 'User::logout');

// Seller Authentication & Portal
$routes->get('seller/login', 'Seller::login');
$routes->post('seller/login-process', 'Seller::loginProcess');
$routes->get('seller/register', 'Seller::register');
$routes->post('seller/register-process', 'Seller::registerProcess');
$routes->get('seller/dashboard', 'Seller::dashboard');
$routes->get('seller/logout', 'Seller::logout');

// Admin Panel Routes
$routes->group('admin', static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::index');
    $routes->get('products', 'Admin::products');
    $routes->get('products/create', 'Admin::createProduct');
    $routes->post('products/store', 'Admin::storeProduct');
    $routes->get('products/edit/(:num)', 'Admin::editProduct/$1');
    $routes->get('products/bulk-import', 'Admin::bulkImport');
    $routes->post('products/bulk-upload', 'Admin::bulkUpload');
    $routes->get('products/bulk-export', 'Admin::bulkExport');
    $routes->get('products/bulk-demo-download', 'Admin::bulkDemoDownload');
    $routes->get('products/(:segment)', 'Admin::products/$1');
    $routes->get('categories', 'Admin::categories');
    $routes->get('categories/create', 'Admin::createCategory');
    $routes->post('categories/store', 'Admin::storeCategory');
    $routes->get('categories/edit/(:num)', 'Admin::editCategory/$1');
    $routes->post('categories/update/(:num)', 'Admin::updateCategory/$1');
    $routes->get('categories/delete/(:num)', 'Admin::deleteCategory/$1');
    $routes->post('categories/update-status', 'Admin::updateCategoryStatus');
    $routes->get('brands', 'Admin::brands');
    $routes->get('brands/create', 'Admin::createBrand');
    $routes->post('brands/store', 'Admin::storeBrand');
    $routes->get('brands/edit/(:num)', 'Admin::editBrand/$1');
    $routes->post('brands/update/(:num)', 'Admin::updateBrand/$1');
    $routes->get('brands/delete/(:num)', 'Admin::deleteBrand/$1');
    $routes->get('attributes', 'Admin::attributes');
    $routes->get('colors', 'Admin::colors');
    $routes->get('product-reviews', 'Admin::productReviews');
    $routes->post('product-reviews/store', 'Admin::storeReview');
    $routes->get('product-reviews/delete/(:num)', 'Admin::deleteReview/$1');
    $routes->get('auction/create', 'Admin::auctionCreate');
    $routes->get('auction/all-products', 'Admin::auctionAllProducts');
    $routes->get('auction/inhouse-products', 'Admin::auctionInhouseProducts');
    $routes->get('auction/seller-products', 'Admin::auctionSellerProducts');
    $routes->get('auction/orders', 'Admin::auctionOrders');
    $routes->get('wholesale/create', 'Admin::wholesaleCreate');
    $routes->get('wholesale/all-products', 'Admin::wholesaleAllProducts');
    $routes->get('wholesale/inhouse-products', 'Admin::wholesaleInhouseProducts');
    $routes->get('wholesale/seller-products', 'Admin::wholesaleSellerProducts');
    $routes->get('units', 'Admin::units');
    $routes->post('units/store', 'Admin::storeUnit');
    $routes->post('units/update', 'Admin::updateUnit');
    $routes->get('units/delete/(:num)', 'Admin::deleteUnit/$1');
    $routes->get('warranties', 'Admin::warranties');
    $routes->post('warranties/store', 'Admin::storeWarranty');
    $routes->post('warranties/update', 'Admin::updateWarranty');
    $routes->get('warranties/delete/(:num)', 'Admin::deleteWarranty/$1');
    $routes->get('size-charts', 'Admin::sizeCharts');
    $routes->post('size-charts/store', 'Admin::storeSizeChart');
    $routes->post('size-charts/update', 'Admin::updateSizeChart');
    $routes->get('size-charts/delete/(:num)', 'Admin::deleteSizeChart/$1');
    $routes->get('measurement-points', 'Admin::measurementPoints');
    $routes->post('measurement-points/store', 'Admin::storeMeasurementPoint');
    $routes->post('measurement-points/update', 'Admin::updateMeasurementPoint');
    $routes->get('measurement-points/delete/(:num)', 'Admin::deleteMeasurementPoint/$1');
    $routes->get('custom-labels', 'Admin::customLabels');
    $routes->post('custom-labels/store', 'Admin::storeCustomLabel');
    $routes->post('custom-labels/update', 'Admin::updateCustomLabel');
    $routes->get('custom-labels/delete/(:num)', 'Admin::deleteCustomLabel/$1');
    $routes->get('category-wise-discount', 'Admin::categoryWiseDiscount');
    $routes->post('category-wise-discount/update', 'Admin::updateCategoryWiseDiscount');
    $routes->get('category-wise-refund', 'Admin::categoryWiseRefund');
    $routes->post('category-wise-refund/update', 'Admin::updateCategoryWiseRefund');
    $routes->get('orders', 'Admin::allOrders');
    $routes->get('orders/all', 'Admin::allOrders');
    $routes->get('orders/inhouse', 'Admin::inhouseOrders');
    $routes->get('orders/seller', 'Admin::sellerOrders');
    $routes->get('orders/pickup-point', 'Admin::pickupPointOrders');
    
    // Delivery Boy
    $routes->get('delivery-boys', 'Admin::deliveryBoys');
    $routes->get('delivery-boys/create', 'Admin::createDeliveryBoy');
    $routes->get('delivery-boys/payments', 'Admin::deliveryBoyPayments');
    $routes->get('delivery-boys/collected', 'Admin::deliveryBoyCollected');
    $routes->get('delivery-boys/cancel-requests', 'Admin::deliveryBoyCancelRequests');
    $routes->get('delivery-boys/config', 'Admin::deliveryBoyConfig');
    
    // Refunds
    $routes->get('refunds/requests', 'Admin::refundRequests');
    $routes->get('refunds/approved', 'Admin::approvedRefunds');
    $routes->get('refunds/rejected', 'Admin::rejectedRefunds');
    $routes->get('refunds/config', 'Admin::refundConfig');
    
    // Customers
    $routes->get('customers', 'Admin::customers');
    $routes->get('customers/classified-products', 'Admin::classifiedProducts');
    $routes->get('customers/classified-packages', 'Admin::classifiedPackages');
    
    // Sellers
    $routes->get('sellers', 'Admin::sellers');
    $routes->get('sellers/payouts', 'Admin::sellerPayouts');
    $routes->get('sellers/payout-requests', 'Admin::sellerPayoutRequests');
    $routes->get('sellers/commission', 'Admin::sellerCommission');
    $routes->get('sellers/packages', 'Admin::sellerPackages');
    $routes->get('sellers/verification-form', 'Admin::sellerVerificationForm');
    
    // Uploaded Files
    $routes->get('uploaded-files', 'Admin::uploadedFiles');
    $routes->post('uploaded-files/upload', 'Admin::uploadMediaFile');
    $routes->post('uploaded-files/delete/(:num)', 'Admin::destroyMediaFile/$1');
    $routes->post('uploaded-files/bulk-delete', 'Admin::bulkDestroyMediaFiles');
    
    // Reports
    $routes->get('reports/inhouse-sales', 'Admin::inhouseSalesReport');
    $routes->get('reports/seller-sales', 'Admin::sellerSalesReport');
    $routes->get('reports/stock', 'Admin::stockReport');
    $routes->get('reports/wishlist', 'Admin::wishlistReport');
    $routes->get('reports/user-searches', 'Admin::userSearchesReport');
    $routes->get('reports/commission-history', 'Admin::commissionHistoryReport');
    $routes->get('reports/wallet-recharge-history', 'Admin::walletRechargeReport');
    
    // Blog System
    $routes->get('blog', 'Admin::blogPosts');
    $routes->get('blog/categories', 'Admin::blogCategories');
    
    // Marketing
    $routes->get('marketing/flash-deals', 'Admin::flashDeals');
    $routes->get('marketing/newsletters', 'Admin::newsletters');
    $routes->get('marketing/subscribers', 'Admin::subscribers');
    $routes->get('marketing/coupons', 'Admin::coupons');
    
    // Support
    $routes->get('support/tickets', 'Admin::supportTickets');
    $routes->get('support/queries', 'Admin::supportQueries');
    
    // Website Settings & Configurations
    $routes->get('website/header', 'Admin::websiteHeader');
    $routes->get('website/footer', 'Admin::websiteFooter');
    $routes->get('website/pages', 'Admin::websitePages');
    $routes->get('website/appearance', 'Admin::websiteAppearance');
    $routes->get('setup/features', 'Admin::setupFeatures');
    $routes->post('setup/features/update', 'Admin::updateFeatureStatus');
    $routes->get('setup/languages', 'Admin::setupLanguages');
    $routes->get('setup/currencies', 'Admin::setupCurrencies');
    $routes->get('setup/payment-methods', 'Admin::setupPaymentMethods');
    $routes->post('setup/payment-methods/update', 'Admin::updatePaymentMethods');
    $routes->get('setup/payment-methods/test-piprapay', 'Admin::testPipraPay');
    $routes->get('setup/vat-tax', 'Admin::setupVatTax');
    $routes->get('setup/pickup-point', 'Admin::setupPickupPoint');
    $routes->get('setup/smtp', 'Admin::setupSmtp');
    $routes->get('setup/order-config', 'Admin::setupOrderConfig');
    $routes->get('setup/file-system', 'Admin::setupFileSystem');
    $routes->get('setup/social-logins', 'Admin::setupSocialLogins');
    $routes->get('setup/facebook/chat', 'Admin::setupFacebookChat');
    $routes->get('setup/facebook/comment', 'Admin::setupFacebookComment');
    $routes->get('setup/google/analytics', 'Admin::setupGoogleAnalytics');
    $routes->get('setup/google/recaptcha', 'Admin::setupGoogleRecaptcha');
    $routes->get('setup/shipping/configuration', 'Admin::setupShippingConfig');
    $routes->post('setup/shipping/configuration/update', 'Admin::updateShippingConfig');
    $routes->get('setup/shipping/countries', 'Admin::setupShippingCountries');
    $routes->post('setup/shipping/countries/status', 'Admin::updateShippingCountryStatus');
    $routes->get('setup/shipping/states', 'Admin::setupShippingStates');
    $routes->get('setup/shipping/cities', 'Admin::setupShippingCities');
    $routes->post('setup/shipping/cities/status', 'Admin::updateShippingCityStatus');
    $routes->get('setup/shipping/zones', 'Admin::setupShippingZones');
    $routes->get('setup/shipping/carriers', 'Admin::setupShippingCarriers');
    
    // Staff & System
    $routes->get('staff', 'Admin::staff');
    $routes->get('staff/roles', 'Admin::staffRoles');
    $routes->get('system/update', 'Admin::systemUpdate');
    $routes->get('system/server-status', 'Admin::serverStatus');
    $routes->get('system/backups', 'Admin::backupAndRestore');

    $routes->get('pos', 'Admin::pos');
    $routes->get('pos-activation', 'Admin::posActivation');
    $routes->get('settings', 'Admin::settings');
    $routes->post('settings/save', 'Admin::saveSettings');
    $routes->get('profile', 'Admin::profile');
    $routes->post('profile/update', 'Admin::updateProfile');
    $routes->get('clear-cache', 'Admin::clearCache');
});

// AIZ Media Uploader Routes
$routes->match(['get', 'post'], 'aiz-uploader', 'AizUploader::index');
$routes->match(['get', 'post'], 'aiz-uploader/get-uploaded-files', 'AizUploader::getUploadedFiles');
$routes->match(['get', 'post'], 'aiz-uploader/get_file_by_ids', 'AizUploader::getFileByIds');
