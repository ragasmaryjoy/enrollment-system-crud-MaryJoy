<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['semester_name'], $data['year_id']) || empty(trim($data['semester_name']))) {
    echo json_encode(['error' => 'ID, semester name and year ID required']);
    exit;
}

$id = intval($data['id']);
$semester_name = mysqli_real_escape_string($conn, trim($data['semester_name']));
$year_id = intval($data['year_id']);

$sql = "UPDATE semesters SET semester_name='$semester_name', year_id=$year_id WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Could not update semester']);
}
?>
