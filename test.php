<?php
require 'backend/config.php';

$databases = $client->listDatabases();
foreach ($databases as $db) {
    echo $db->getName() . "<br>";
}
