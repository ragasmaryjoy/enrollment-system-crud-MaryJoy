<?php
header('Content-Type: application/json');
require_once '../pdo.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['name']) || !isset($data['email'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing id, name, or email'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$data['name'], $data['email'], $data['id']]);

    echo json_encode([
        'success' => true,
        'message' => 'Student updated successfully'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
