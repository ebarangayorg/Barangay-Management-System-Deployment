<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $case_no = $_POST["case_no"];
    $date_filed = $_POST["date_filed"];
    $complainant = $_POST["complainant"];
    $respondent = $_POST["respondent"];
    $subject = $_POST["subject"];
    $description = $_POST["description"];

    $document = [
        "case_no" => $case_no,
        "date_filed" => $date_filed,
        "complainant" => $complainant,
        "respondent" => $respondent,
        "subject" => $subject,
        "description" => $description,
        "status" => "active",  
        "created_at" => date("Y-m-d H:i:s")
    ];

    $incidentsCollection->insertOne($document);

    header("Location: ../pages/admin/admin_rec_blotter.php");
    exit();
}
?>