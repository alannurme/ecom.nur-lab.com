<?php
$f = 'app/Views/admin/layouts/header.php';
$c = file_get_contents($f);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Brand</span></a>',
    '<a href="<?= base_url(\'admin/brands\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Brand</span></a>',
    $c
);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Attribute</span></a>',
    '<a href="<?= base_url(\'admin/attributes\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Attribute</span></a>',
    $c
);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Colors</span></a>',
    '<a href="<?= base_url(\'admin/colors\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Colors</span></a>',
    $c
);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Product Reviews</span></a>',
    '<a href="<?= base_url(\'admin/product-reviews\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Product Reviews</span></a>',
    $c
);
file_put_contents($f, $c);
echo "NAV LINKS UPDATED\n";
