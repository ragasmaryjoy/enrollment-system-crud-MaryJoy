<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../db_connection.php";

try {
    $stmt = $conn->prepare("
        SELECT 
            p.program_id, 
            p.program_name, 
            i.ins_id, 
            i.institute_name
        FROM 
            program_tbl p
        JOIN 
            institute_tbl i ON p.ins_id = i.ins_id
    ");
    $stmt->execute();
    $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $programs
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
