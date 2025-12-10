<?php
require_once "cloudinary_config.php"; // Include Cloudinary setup
require_once "config.php";             // MongoDB connection

$title = $_POST["title"];
$details = $_POST["details"];
$location = $_POST["location"];
$date = $_POST["date"];
$time = $_POST["time"];

$image_url = null;

if (!empty($_FILES["photo"]["name"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES["photo"]["tmp_name"];

    $uploadResult = $cloudinary->uploadApi()->upload($uploadedFile, [
        'folder' => 'announcements', // optional: organize files
    ]);

    $image_url = $uploadResult['secure_url']; // Cloudinary URL
}

// Insert into database
$announcementCollection->insertOne([
    "title"    => $title,
    "details"  => $details,
    "location" => $location,
    "date"     => $date,
    "time"     => $time,
    "image"    => $image_url,
    "status"   => "active",
]);

header("Location: ../pages/admin/admin_announcement.php");
exit;
