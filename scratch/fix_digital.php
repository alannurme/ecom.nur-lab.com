<?php
$f = 'app/Views/admin/layouts/header.php';
$lines = explode("\n", file_get_contents($f));
foreach ($lines as $i => $line) {
    if (strpos($line, 'Digital Products') !== false && isset($lines[$i-1]) && strpos($lines[$i-1], 'admin/products/digital') !== false && $i > 200) {
        $lines[$i-1] = str_replace('admin/products/digital', 'admin/products/seller-digital', $lines[$i-1]);
    }
}
file_put_contents($f, implode("\n", $lines));
echo "DONE\n";
