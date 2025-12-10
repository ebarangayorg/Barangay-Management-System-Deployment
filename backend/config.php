<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env for LOCAL ONLY
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// FULL FALLBACK CHAIN (Works on Local, Docker, Railway)
$mongoUri = $_ENV['MONGO_URI']
    ?? $_SERVER['MONGO_URI']
    ?? getenv('MONGO_URI')
    ?? null;

$dbName = $_ENV['DB_NAME']
    ?? $_SERVER['DB_NAME']
    ?? getenv('DB_NAME')
    ?? null;

if (!$mongoUri || !$dbName) {
    die("
        MONGO_URI or DB_NAME not found.<br>
        Loaded values:<br>
        \$_ENV: " . var_export($_ENV, true) . "<br>
        \$_SERVER[MONGO_URI]: " . ($_SERVER['MONGO_URI'] ?? 'NULL') . "<br>
        getenv(MONGO_URI): " . getenv('MONGO_URI') . "<br>
        <br>
        Railway variables are NOT being read by PHP.
    ");
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
