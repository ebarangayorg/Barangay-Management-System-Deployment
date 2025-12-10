<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env locally (only used on local dev)
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// Get MongoDB credentials reliably for Local, Docker, Railway
$mongoUri = $_ENV['MONGO_URI'] ?? $_SERVER['MONGO_URI'] ?? getenv('MONGO_URI') 
            ?? die("Error: MONGO_URI not set");
$dbName   = $_ENV['DB_NAME']  ?? $_SERVER['DB_NAME']  ?? getenv('DB_NAME') 
            ?? die("Error: DB_NAME not set");

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
