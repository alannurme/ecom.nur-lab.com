<?php
$files = [
    'active/resources/views/backend/product/brands/index.blade.php',
    'active/resources/views/backend/product/attribute/index.blade.php',
    'active/resources/views/backend/product/color/index.blade.php',
    'active/resources/views/backend/product/reviews/index.blade.php'
];
foreach ($files as $f) {
    if (file_exists($f)) {
        file_put_contents($f, '');
        echo "CLEARED: " . $f . "\n";
    }
}
