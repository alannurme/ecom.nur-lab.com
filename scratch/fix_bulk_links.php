<?php
$f = 'app/Views/admin/layouts/header.php';
$lines = explode("\n", file_get_contents($f));
foreach ($lines as $i => $line) {
    if (strpos($line, 'Bulk Import') !== false && isset($lines[$i-1]) && strpos($lines[$i-1], '<a href="#"') !== false) {
        $lines[$i-1] = str_replace('#', base_url('admin/products/bulk-import'), $lines[$i-1]);
    }
    if (strpos($line, 'Bulk Export') !== false && isset($lines[$i-1]) && strpos($lines[$i-1], '<a href="#"') !== false) {
        $lines[$i-1] = str_replace('#', base_url('admin/products/bulk-export'), $lines[$i-1]);
    }
}
file_put_contents($f, implode("\n", $lines));
echo "BULK LINKS UPDATED\n";
