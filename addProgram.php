<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['program_name'], $data['ins_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: program_name and ins_id"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO program_tbl (program_name, ins_id) 
        VALUES (:program_name, :ins_id)
    ");
    $stmt->bindParam(':program_name', $data['program_name']);
    $stmt->bindParam(':ins_id', $data['ins_id']);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Program added successfully",
        "program_id" => $conn->lastInsertId()
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
