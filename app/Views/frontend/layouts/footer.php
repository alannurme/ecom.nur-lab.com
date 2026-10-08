    <!-- Policy Badges Section -->
    <section class="border-top border-bottom bg-white mt-auto py-4">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-3 col-6 text-center p-3 border-right border-bottom border-md-bottom-0">
                    <i class="las la-file-alt fs-32 text-primary"></i>
                    <h5 class="fs-14 fw-700 mt-2 mb-0">Terms & Conditions</h5>
                </div>
                <div class="col-lg-3 col-6 text-center p-3 border-right border-bottom border-md-bottom-0">
                    <i class="las la-undo-alt fs-32 text-primary"></i>
                    <h5 class="fs-14 fw-700 mt-2 mb-0">Return Policy</h5>
                </div>
                <div class="col-lg-3 col-6 text-center p-3 border-right">
                    <i class="las la-headset fs-32 text-primary"></i>
                    <h5 class="fs-14 fw-700 mt-2 mb-0">Support Policy</h5>
                </div>
                <div class="col-lg-3 col-6 text-center p-3">
                    <i class="las la-user-shield fs-32 text-primary"></i>
                    <h5 class="fs-14 fw-700 mt-2 mb-0">Privacy Policy</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Footer -->
    <?php
    $footerSettingModel = new \App\Models\SettingModel();
    $footerSystemLogo = $footerSettingModel->getSetting('system_logo', 'assets/img/logo.png');
    ?>
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-6 col-lg-7 mb-4">
                    <div class="mb-3">
                        <a href="<?= base_url() ?>" class="d-inline-block text-decoration-none">
                            <img src="<?= base_url($footerSystemLogo) ?>" class="mh-50px h-50px max-w-240px" alt="<?= esc($site_name ?? 'Logo') ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                            <span class="fs-24 fw-800 text-primary" style="display:none;">
                                <i class="las la-shopping-bag"></i> <?= esc($site_name ?? 'NUR-LAB ECOM') ?>
                            </span>
                        </a>
                    </div>
                    <p class="text-secondary fs-13 text-justify pr-xl-5">
                        Your trusted e-commerce platform for top quality networking equipment, Routers, Smart Watches, Gadgets, and Electronics in Bangladesh. Fast shipping and 100% authentic product warranty.
                    </p>
                    <div class="mt-4">
                        <h6 class="fs-13 fw-700 text-white mb-2">Subscribe to our newsletter for regular updates</h6>
                        <form action="#" method="POST">
                            <div class="row gutters-10">
                                <div class="col-8">
                                    <input type="email" class="form-control rounded-0 bg-transparent text-white border-secondary fs-13" placeholder="Your Email Address" required>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary rounded-0 w-100 fs-13 fw-700">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 mb-4 ml-auto">
                    <h6 class="fs-14 fw-700 text-white mb-3">Follow Us</h6>
                    <ul class="list-inline social colored mb-4">
                        <li class="list-inline-item mr-2">
                            <a href="#" class="facebook text-white fs-20"><i class="lab la-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item mr-2">
                            <a href="#" class="instagram text-white fs-20"><i class="lab la-instagram"></i></a>
                        </li>
                        <li class="list-inline-item mr-2">
                            <a href="#" class="youtube text-white fs-20"><i class="lab la-youtube"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="whatsapp text-white fs-20"><i class="lab la-whatsapp"></i></a>
                        </li>
                    </ul>

                    <h6 class="fs-14 fw-700 text-white mb-2">Mobile Apps</h6>
                    <div class="d-flex">
                        <a href="#" class="mr-2">
                            <img src="<?= base_url('assets/img/play.png') ?>" alt="Play Store" height="40" onerror="this.style.display='none'">
                        </a>
                        <a href="#">
                            <img src="<?= base_url('assets/img/app.png') ?>" alt="App Store" height="40" onerror="this.style.display='none'">
                        </a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="row align-items-center fs-13 text-secondary">
                <div class="col-md-6 text-center text-md-left">
                    &copy; <?= date('Y') ?> <?= esc($site_name ?? 'NUR-LAB ECOM') ?>. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">
                    <span>Powered by CodeIgniter 4</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom border-top bg-white py-2 shadow-lg">
        <div class="row align-items-center text-center gutters-5">
            <div class="col">
                <a href="<?= base_url() ?>" class="text-reset d-block text-decoration-none">
                    <i class="las la-home fs-20 text-primary"></i>
                    <span class="d-block fs-10 fw-600 text-primary">Home</span>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-reset d-block text-decoration-none">
                    <i class="las la-list fs-20 text-muted"></i>
                    <span class="d-block fs-10 fw-600 text-muted">Categories</span>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-reset d-block text-decoration-none">
                    <i class="las la-shopping-cart fs-20 text-muted"></i>
                    <span class="d-block fs-10 fw-600 text-muted">Cart</span>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-reset d-block text-decoration-none">
                    <i class="las la-user fs-20 text-muted"></i>
                    <span class="d-block fs-10 fw-600 text-muted">Account</span>
                </a>
            </div>
        </div>
    </div>

</div> <!-- End aiz-main-wrapper -->

    <!-- Theme JS Files -->
    <script src="<?= base_url('assets/js/vendors.js') ?>"></script>
    <script src="<?= base_url('assets/js/aiz-core.js') ?>"></script>
    <script>
        $(document).ready(function() {
            if (typeof AIZ.plugins.slickCarousel === 'function') {
                AIZ.plugins.slickCarousel();
            }
        });
    </script>
</body>
</html>
