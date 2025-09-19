<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

if (!isset($_GET['student_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing student_id parameter"
    ]);
    exit;
}

$student_id = $_GET['student_id'];

try {
    $stmt = $conn->prepare("
        SELECT 
            e.enrollment_id,
            s.subject_id,
            s.subject_name
        FROM 
            enrollment_tbl e
        JOIN 
            subject_tbl s ON e.subject_id = s.subject_id
        WHERE 
            e.student_id = :student_id
    ");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $enrollments
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
