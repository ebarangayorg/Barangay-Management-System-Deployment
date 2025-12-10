<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env locally ONLY
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// FULL FALLBACK for local, Docker, Railway
$mongoUri = $_ENV['MONGO_URI'] ?? $_SERVER['MONGO_URI'] ?? getenv('MONGO_URI') ?? null;
$dbName   = $_ENV['DB_NAME']   ?? $_SERVER['DB_NAME']   ?? getenv('DB_NAME')   ?? null;

if (!$mongoUri || !$dbName) {
    die("Error: MONGO_URI or DB_NAME not set.<br>
         \$_ENV: " . var_export($_ENV, true) . "<br>
         \$_SERVER: " . var_export($_SERVER, true) . "<br>
         getenv(MONGO_URI): " . getenv('MONGO_URI'));
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
