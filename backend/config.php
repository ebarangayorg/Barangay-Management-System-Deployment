<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");

    $database = $client->bms_db;

    $usersCollection = $database->users;
    $residentsCollection = $database->residents;
    $officialsCollection = $database->officials;
    $contactsCollection = $database->contacts;
    $incidentsCollection = $database->incidents;
    $announcementCollection = $database->announcements;
    $total_population = $residentsCollection->countDocuments();
    $total_households = $residentsCollection->distinct('household_id');
    $total_households_count = count($total_households);
    
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
?>
