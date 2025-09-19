<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['error' => 'ID required']);
    exit;
}

$id = intval($data['id']);

// Because of ON DELETE CASCADE, semesters linked will auto-delete
$sql = "DELETE FROM years WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Could not delete year']);
}
?>
