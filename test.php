<?php
require 'backend/config.php';
$dbs = $client->listDatabases();
foreach($dbs as $db) {
    echo $db->getName() . "<br>";
}
