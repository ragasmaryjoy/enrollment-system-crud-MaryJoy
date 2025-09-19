<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['student_id'], $data['subject_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: student_id and subject_id"
    ]);
    exit;
}

try {
    // Check if already enrolled
    $check = $conn->prepare("
        SELECT * FROM enrollment_tbl 
        WHERE student_id = :student_id AND subject_id = :subject_id
    ");
    $check->execute([
        ':student_id' => $data['student_id'],
        ':subject_id' => $data['subject_id']
    ]);

    if ($check->rowCount() > 0) {
        echo json_encode([
            "success" => false,
            "message" => "Student is already enrolled in this subject"
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO enrollment_tbl (student_id, subject_id) 
        VALUES (:student_id, :subject_id)
    ");
    $stmt->execute([
        ':student_id' => $data['student_id'],
        ':subject_id' => $data['subject_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Student enrolled successfully",
        "enrollment_id" => $conn->lastInsertId()
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
