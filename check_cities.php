<?php
$c = new mysqli('localhost', 'root', 'Al04@95annur', 'ecom');
$r = $c->query('SHOW COLUMNS FROM cities');
if ($r) {
    while($row = $r->fetch_assoc()) {
        echo implode(' | ', $row).PHP_EOL;
    }
} else {
    echo "No table cities found.";
}
