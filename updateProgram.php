<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['program_id'], $data['program_name'], $data['ins_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: program_id, program_name, and ins_id"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("
        UPDATE program_tbl 
        SET program_name = :program_name, ins_id = :ins_id 
        WHERE program_id = :program_id
    ");
    $stmt->bindParam(':program_id', $data['program_id']);
    $stmt->bindParam(':program_name', $data['program_name']);
    $stmt->bindParam(':ins_id', $data['ins_id']);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Program updated successfully"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
