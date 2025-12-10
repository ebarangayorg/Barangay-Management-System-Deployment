<?php
require_once "../cloudinary_config.php"; // Cloudinary setup
require_once "config.php";             // MongoDB connection

$id = $_POST["id"];

// Build update array safely
$updateData = array_filter([
    "title"    => $_POST["title"] ?? null,
    "details"  => $_POST["details"] ?? null,
    "location" => $_POST["location"] ?? null,
    "date"     => $_POST["date"] ?? null,
    "time"     => $_POST["time"] ?? null,
    "status"   => $_POST["status"] ?? null  
]);

// Upload new image to Cloudinary
if (!empty($_FILES["photo"]["name"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES["photo"]["tmp_name"];

    $uploadResult = $cloudinary->uploadApi()->upload($uploadedFile, [
        'folder' => 'announcements', // optional folder in Cloudinary
    ]);

    $updateData["image"] = $uploadResult['secure_url']; // store Cloudinary URL
}

// Update announcement in MongoDB
$announcementCollection->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($id)],
    ['$set' => $updateData]
);

// Redirect depending on status
$status = $_POST["status"] ?? null;
if ($status === "archived") {
    header("Location: ../pages/admin/admin_announcement_archive.php");
} else {
    header("Location: ../pages/admin/admin_announcement.php");
}
exit;
