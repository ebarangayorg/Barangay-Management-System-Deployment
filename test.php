<?php
require 'backend/config.php';

echo "<h3>MongoDB connection test</h3>";

try {
    $dbs = $client->listDatabases();
    echo "Databases:<br>";
    foreach ($dbs as $db) {
        echo "- " . $db->getName() . "<br>";
    }
} catch (Exception $e) {
    die("MongoDB test failed: " . $e->getMessage());
}
