<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    require __DIR__ . '/../../backend/config.php';
    $collection = $db->announcements;

    // Only active announcements (not archived)
    $result = $collection->find(
        ["status" => "active"],
        ["sort" => ["date" => 1]]
    );

    $announcements = [];

    foreach ($result as $doc) {
        $announcements[] = [
            "title" => $doc->title ?? "",
            "details" => $doc->details ?? "",
            "location" => $doc->location ?? "",
            "date" => $doc->date ?? "",
            "time" => $doc->time ?? ""
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($announcements);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
