<?php
require_once "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$residentId = new MongoDB\BSON\ObjectId($_POST["user_id"]);

$uploadedImage = $_FILES['profile_image'] ?? null;
$existingImage = $_POST['existing_image'] ?? "";
$finalImageName = $existingImage; 

if ($uploadedImage && $uploadedImage['error'] === UPLOAD_ERR_OK) {

    $ext = pathinfo($uploadedImage['name'], PATHINFO_EXTENSION);
    $newFileName = "residents/" . uniqid("img_") . "." . $ext;
    $destination = "../assets/img/" . $newFileName;

    // Move uploaded file
    move_uploaded_file($uploadedImage["tmp_name"], $destination);

    $finalImageName = $newFileName;
}

$residentsCollection->updateOne(
    ["_id" => $residentId],
    ['$set' => [
        "first_name" => $_POST["fname"],
        "middle_name" => $_POST["mname"],
        "last_name" => $_POST["lname"],
        "suffix" => $_POST["sname"],

        "gender" => $_POST["gender"],
        "birthdate" => $_POST["bdate"],
        "birthplace" => $_POST["bplace"],

        "purok" => $_POST["purok"],
        "occupation" => $_POST["occupation"],
        "resident_since" => $_POST["resident_since"],

        "contact" => $_POST["contact"],
        "email" => $_POST["email"],

        "voter" => $_POST["voter_status"],
        "income" => $_POST["income"],
        "family_head" => $_POST["family_head"],

        "profile_image" => $finalImageName,
    ]]
);

header("Location: ../pages/resident/resident_dashboard.php?updated=true");
exit;
?>
