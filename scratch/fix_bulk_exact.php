<?php
$f = 'app/Views/admin/layouts/header.php';
$c = file_get_contents($f);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Import</span></a>',
    '<a href="<?= base_url(\'admin/products/bulk-import\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Import</span></a>',
    $c
);
$c = str_replace(
    '<a href="#" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Export</span></a>',
    '<a href="<?= base_url(\'admin/products/bulk-export\') ?>" class="aiz-side-nav-link"><span class="aiz-side-nav-text">Bulk Export</span></a>',
    $c
);
file_put_contents($f, $c);
echo "REPLACED BULK LINKS\n";
