<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

// Load .env locally
$dotenvPath = __DIR__ . "/../";
if (file_exists($dotenvPath . ".env")) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

try {
    $mongoUri = getenv('MONGO_URI') ?: ($_ENV['MONGO_URI'] ?? null);
    $dbName   = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? null);

    if (!$mongoUri || !$dbName) {
        throw new Exception("MongoDB connection info not set in environment variables.");
    }

    $client = new MongoDB\Client($mongoUri);
    $database = $client->selectDatabase($dbName);

} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
