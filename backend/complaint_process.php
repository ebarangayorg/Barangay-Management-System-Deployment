<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Insert into contacts collection
    $contactsCollection->insertOne([
        'fullname' => $fullname,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
        'date' => new MongoDB\BSON\UTCDateTime()
    ]);

    header("Location: ../contact.php?success=1");
    exit;
}
?>
