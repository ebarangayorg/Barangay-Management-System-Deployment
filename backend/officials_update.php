<?php
require_once "config.php";

$id = $_POST["id"];
$updateData = array_filter([
    "name"     => $_POST["name"] ?? null,
    "position" => $_POST["position"] ?? null,
    "status"   => $_POST["status"] ?? null
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

header("Location: " . ($_POST["status"] === "archived" ? "../pages/admin/admin_officials_archive.php" : "../pages/admin/admin_officials.php"));
exit;
