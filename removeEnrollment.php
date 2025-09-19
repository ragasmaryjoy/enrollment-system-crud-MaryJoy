<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['enrollment_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required field: enrollment_id"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM enrollment_tbl WHERE enrollment_id = :enrollment_id");
    $stmt->execute([
        ':enrollment_id' => $data['enrollment_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Enrollment removed successfully"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
