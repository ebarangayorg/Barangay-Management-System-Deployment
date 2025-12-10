<?php
require_once __DIR__ . '/config.php';

try {
    $users = $usersCollection->find()->toArray();
    echo "Users found: " . count($users);
} catch (Exception $e) {
    die("MongoDB error: " . $e->getMessage());
}
