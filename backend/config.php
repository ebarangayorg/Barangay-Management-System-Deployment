<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env ONLY for local development
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// Railway uses getenv()
$mongoUri = $_ENV['MONGO_URI'] ?? getenv('MONGO_URI');
$dbName   = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

if (!$mongoUri || !$dbName) {
    die("Error: Missing MONGO_URI or DB_NAME. Values: "
        . "MONGO_URI=" . var_export($mongoUri, true)
        . " DB_NAME=" . var_export($dbName, true)
    );
}

try {
    $client = new MongoDB\Client($mongoUri);
    $database = $client->selectDatabase($dbName);

    // Collections
    $usersCollection        = $database->users;
    $residentsCollection    = $database->residents;
    $officialsCollection    = $database->officials;
    $contactsCollection     = $database->contacts;
    $incidentsCollection    = $database->incidents;
    $announcementCollection = $database->announcements;
    $issuanceCollection     = $database->issuances;

} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
