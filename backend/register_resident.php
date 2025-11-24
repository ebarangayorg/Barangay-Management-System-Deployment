<?php
require_once 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $existingUser = $usersCollection->findOne(["email" => $email]);
    if ($existingUser) {
        die("Email already exists!");
    }

    $userData = [
        "email" => $email,
        "password" => $password,
        "role" => "Resident",
        "status" => "Pending",  
        "date_created" => new MongoDB\BSON\UTCDateTime()
    ];

    $insertUser = $usersCollection->insertOne($userData);
    $userId = $insertUser->getInsertedId(); 

    $residentData = [
        "user_id" => $userId,           
        "first_name" => $_POST['fname'],
        "middle_name" => $_POST['mname'],
        "last_name" => $_POST['lname'],
        "suffix" => $_POST['sname'],
        "gender" => $_POST['gender'],
        "birthdate" => $_POST['bdate'],
        "birthplace" => $_POST['bplace'],
        "purok" => $_POST['purok'],
        "contact" => $_POST['contact'],
        "occupation" => $_POST['occupation'],
        "resident_since" => $_POST['resident_since'],
        "email" => $email,
        "voter" => $_POST['voter'] ?? "No",
        "income" => $_POST['income'],
        "family_head" => $_POST['family_head']
    ];

    $residentsCollection->insertOne($residentData);

    echo "<script>alert('Registration successful! Please wait for approval.'); window.location.href='../resident_login.php' </script>";
    exit;
}
?>
