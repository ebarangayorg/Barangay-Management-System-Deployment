<?php
require_once __DIR__ . '/config.php';
echo "MongoDB URI: " . ($mongoUri ?? 'NULL') . "<br>";
echo "DB Name: " . ($dbName ?? 'NULL') . "<br>";
