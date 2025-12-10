<?php
// Always first: session handling (optional if you start sessions in pages)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload dependencies
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

// Load .env locally (won’t be used on Railway)
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

try {
    // Get MongoDB info from Railway env first, then .env
    $mongoUri = getenv('MONGO_URI') ?: ($_ENV['MONGO_URI'] ?? null);
    $dbName   = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? null);

    if (!$mongoUri || !$dbName) {
        throw new Exception("MongoDB connection info not set in environment variables.");
    }

    // Connect to MongoDB
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
    // Stop execution and log error
    die("Error connecting to MongoDB: " . $e->getMessage());
}
