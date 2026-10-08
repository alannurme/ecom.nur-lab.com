<?php
$f = 'app/Views/admin/layouts/header.php';
$lines = explode("\n", file_get_contents($f));
foreach ($lines as $i => $line) {
    if (strpos($line, 'Add New Auction Product') !== false && strpos($line, '<a href="#"') !== false) {
        $lines[$i] = str_replace('<a href="#"', '<a href="<?= base_url(\'admin/auction/create\') ?>"', $line);
    }
    if (strpos($line, 'All Auction Products') !== false && strpos($line, '<a href="#"') !== false) {
        $lines[$i] = str_replace('<a href="#"', '<a href="<?= base_url(\'admin/auction/all-products\') ?>"', $line);
    }
    if (strpos($line, 'Inhouse Auction Products') !== false && strpos($line, '<a href="#"') !== false) {
        $lines[$i] = str_replace('<a href="#"', '<a href="<?= base_url(\'admin/auction/inhouse-products\') ?>"', $line);
    }
    if (strpos($line, 'Seller Auction Products') !== false && strpos($line, '<a href="#"') !== false) {
        $lines[$i] = str_replace('<a href="#"', '<a href="<?= base_url(\'admin/auction/seller-products\') ?>"', $line);
    }
    if (strpos($line, 'Auction Products Orders') !== false && strpos($line, '<a href="#"') !== false) {
        $lines[$i] = str_replace('<a href="#"', '<a href="<?= base_url(\'admin/auction/orders\') ?>"', $line);
    }
}
file_put_contents($f, implode("\n", $lines));
echo "AUCTION NAV UPDATED\n";
