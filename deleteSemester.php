<?php
header('Content-Type: application/json');
include 'dbcon.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['error' => 'ID required']);
    exit;
}

$id = intval($data['id']);

$sql = "DELETE FROM semesters WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Could not delete semester']);
}
?>
