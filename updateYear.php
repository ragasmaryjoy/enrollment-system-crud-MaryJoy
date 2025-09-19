<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['year_name']) || empty(trim($data['year_name']))) {
    echo json_encode(['error' => 'ID and year name required']);
    exit;
}

$id = intval($data['id']);
$year_name = mysqli_real_escape_string($conn, trim($data['year_name']));

$sql = "UPDATE years SET year_name='$year_name' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Could not update year']);
}
?>
