<?php
header('Content-Type: application/json');
require_once '../pdo.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM students");
    $stmt->execute();
    $students = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'message' => 'Students retrieved successfully',
        'data' => $students
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'data' => []
    ]);
}
