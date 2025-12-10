<?php
require_once "config.php";
require_once "auth_admin.php";

header("Content-Type: application/json");

// Validate ID
if (!isset($_POST["issuance_id"]) || empty($_POST["issuance_id"])) {
    echo json_encode(["status" => "error", "message" => "Missing issuance ID."]);
    exit();
}

$id = $_POST["issuance_id"];
$status = $_POST["status"] ?? "Pending";

// Normalize status (Approved → Approved, approved → Approved)
$status = ucwords(strtolower($status));

$updateFields = ['status' => $status];

// Update only fields that exist for THIS document type
$possibleFields = [
    'certificate_for',
    'certificate_for_fullname',
    'purpose',
    'business_name',
    'business_location',
    'reason'
];

foreach ($possibleFields as $field) {
    if (isset($_POST[$field])) {
        $updateFields[$field] = trim($_POST[$field]);
    }
}

try {
    $issuanceCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => $updateFields]
    );

    // ALWAYS return JSON for AJAX
    echo json_encode([
        "status" => "success",
        "updated" => $updateFields
    ]);
    exit();

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit();
}
