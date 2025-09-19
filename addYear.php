<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['year_name']) || empty(trim($data['year_name']))) {
    echo json_encode(['error' => 'Year name is required']);
    exit;
}

$year_name = mysqli_real_escape_string($conn, trim($data['year_name']));

$sql = "INSERT INTO years (year_name) VALUES ('$year_name')";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'id' => mysqli_insert_id($conn)]);
} else {
    echo json_encode(['error' => 'Could not add year']);
}
?>
