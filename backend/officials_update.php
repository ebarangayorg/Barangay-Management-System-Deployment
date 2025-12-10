<?php
require_once "config.php";

$id = $_POST["id"];
$status = $_POST["status"] ?? null; // Safe access

$updateData = array_filter([
    "name"     => $_POST["name"] ?? null,
    "position" => $_POST["position"] ?? null,
    "status"   => $status
]);

if (!empty($_FILES["photo"]["name"])) {
    $filename = time() . "_" . basename($_FILES["photo"]["name"]);
    $target = UPLOADS_DIR . "/officials/" . $filename;
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
    $updateData["image"] = $filename;
}

$officialsCollection->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($id)],
    ['$set' => $updateData]
);

// Redirect safely
if ($status === "archived") {
    header("Location: ../pages/admin/admin_officials_archive.php");
} else {
    header("Location: ../pages/admin/admin_officials.php");
}
exit;
