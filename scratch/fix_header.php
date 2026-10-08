<?php
$f = 'app/Views/admin/layouts/header.php';
$c = file_get_contents($f);
$c = str_replace("base_url('admin/products/seller')", "base_url('admin/products/seller-physical')", $c);
$c = str_replace("<a href=\"<?= base_url('admin/products/digital') ?>\" class=\"aiz-side-nav-link\">\n                                                 <span class=\"aiz-side-nav-text\">Digital Products</span>", "<a href=\"<?= base_url('admin/products/seller-digital') ?>\" class=\"aiz-side-nav-link\">\n                                                 <span class=\"aiz-side-nav-text\">Digital Products</span>", $c);
file_put_contents($f, $c);
echo "DONE\n";
