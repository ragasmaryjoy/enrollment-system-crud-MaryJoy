<?php
header('Content-Type: application/json');
require_once '../pdo.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing student ID'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$data['id']]);

    echo json_encode([
        'success' => true,
        'message' => 'Student deleted successfully'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
