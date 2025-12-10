<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

// Load .env locally (only if exists)
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

try {
    // First try Railway / system env, then .env
    $mongoUri = getenv('MONGO_URI') ?: ($_ENV['MONGO_URI'] ?? null);
    $dbName   = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? null);

    if (!$mongoUri || !$dbName) {
        throw new Exception("MongoDB connection info not set in environment variables.");
    }

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
