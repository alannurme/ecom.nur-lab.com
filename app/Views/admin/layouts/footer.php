            </div> <!-- End aiz-main-content -->
            
            <div class="bg-white border-top text-center py-3 fs-12 text-muted">
                &copy; <?= date('Y') ?> <?= esc($site_name ?? 'NUR-LAB ECOM') ?>. All rights reserved.
            </div>
        </div> <!-- End aiz-content-wrapper -->
    </div> <!-- End aiz-main-wrapper -->

    <script src="<?= base_url('assets/js/vendors.js') ?>"></script>
    <script src="<?= base_url('assets/js/aiz-core.js') ?>"></script>

    <script>
    $(document).ready(function() {
        // Toggle Sidebar accordion submenus on click
        $(document).on('click', '.aiz-side-nav-item > a', function(e) {
            var $link = $(this);
            var $li = $link.parent('.aiz-side-nav-item');
            var $sub = $li.children('ul.aiz-side-nav-list');

            if ($sub.length > 0) {
                e.preventDefault();
                e.stopPropagation();

                if ($li.hasClass('mm-active') || $li.hasClass('open') || $sub.hasClass('mm-show')) {
                    $li.removeClass('mm-active open active');
                    $sub.removeClass('mm-show').hide();
                } else {
                    $li.siblings('.aiz-side-nav-item').removeClass('mm-active open active').children('ul.aiz-side-nav-list').removeClass('mm-show').hide();
                    $li.addClass('mm-active open active');
                    $sub.addClass('mm-show').show();
                }
            }
        });

        // Auto highlight active menu item (only first match) & expand parent dropdowns based on URL
        var currentUrl = window.location.href.split(/[?#]/)[0].replace(/\/$/, "");
        var $matchedLink = null;
        $('#main-menu a').each(function() {
            var href = (this.href || '').split(/[?#]/)[0].replace(/\/$/, "");
            if (href && href !== '#' && href.indexOf('javascript:') === -1 && href === currentUrl) {
                if (!$matchedLink) {
                    $matchedLink = $(this);
                }
            }
        });

        if ($matchedLink) {
            $matchedLink.addClass('active text-primary fw-600');
            $matchedLink.parents('.aiz-side-nav-item').addClass('mm-active open active');
            $matchedLink.parents('ul.aiz-side-nav-list').addClass('mm-show').css('display', 'block');
        }

        // Mobile Nav Toggle Button
        $(document).on('click', '[data-toggle="aiz-mobile-nav"]', function(e) {
            e.preventDefault();
            $('.aiz-sidebar-wrap').toggleClass('open');
        });

        // Ensure all Bootstrap dropdown toggles work properly on click
        $(document).on('click', '[data-toggle="dropdown"]', function(e) {
            e.stopPropagation();
            var $el = $(this);
            var $parent = $el.closest('.dropdown');
            var isOpen = $parent.hasClass('show');
            $('.dropdown.show').removeClass('show').find('.dropdown-menu').removeClass('show');
            if (!isOpen) {
                $parent.addClass('show');
                $parent.find('.dropdown-menu').addClass('show');
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown.show').removeClass('show').find('.dropdown-menu').removeClass('show');
            }
        });
    });

    // Menu search function
    function menuSearch() {
        var filter = $('#menu-search').val().toLowerCase();
        if (filter.length > 0) {
            $('#main-menu .aiz-side-nav-item').each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(filter) > -1) {
                    $(this).show();
                    $(this).parents('.aiz-side-nav-item').show();
                    $(this).children('ul').show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            $('#main-menu .aiz-side-nav-item').show();
            $('#main-menu .level-2, #main-menu .level-3').hide();
        }
    }
    </script>
</body>
</html>
