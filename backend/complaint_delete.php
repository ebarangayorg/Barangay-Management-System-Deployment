<?php
require_once 'config.php';

if (!isset($_POST['complaint_id'])) {
    die("Error: Missing complaint ID.");
}

$id = $_POST['complaint_id'];

$deleteResult = $contactsCollection->deleteOne([
    '_id' => new MongoDB\BSON\ObjectId($id)
]);

if ($deleteResult->getDeletedCount() === 1) {
    header("Location: ../pages/admin/admin_rec_complaints.php?deleted=1");
    exit;
} else {
    echo "Error deleting record.";
}
?>
