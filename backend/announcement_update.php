<?php
require_once "config.php";

$id = $_POST["id"];
$updateData = array_filter([
    "title"    => $_POST["title"] ?? null,
    "details"  => $_POST["details"] ?? null,
    "location" => $_POST["location"] ?? null,
    "date"     => $_POST["date"] ?? null,
    "time"     => $_POST["time"] ?? null,
    "status"   => $_POST["status"] ?? null
]);

if (!empty($_FILES["photo"]["name"])) {
    $filename = time() . "_" . basename($_FILES["photo"]["name"]);
    $target = UPLOADS_DIR . "/announcements/" . $filename;
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
    $updateData["image"] = $filename;
}

$announcementCollection->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($id)],
    ['$set' => $updateData]
);

header("Location: " . ($_POST["status"] === "archived" ? "../pages/admin/admin_announcement_archive.php" : "../pages/admin/admin_announcement.php"));
exit;
