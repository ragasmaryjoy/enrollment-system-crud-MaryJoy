<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['enrollment_id'], $data['subject_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: enrollment_id and subject_id"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("
        UPDATE enrollment_tbl 
        SET subject_id = :subject_id 
        WHERE enrollment_id = :enrollment_id
    ");
    $stmt->execute([
        ':subject_id' => $data['subject_id'],
        ':enrollment_id' => $data['enrollment_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Enrollment updated successfully"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
