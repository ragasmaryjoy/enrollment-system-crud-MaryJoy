<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['semester_name'], $data['year_id']) || empty(trim($data['semester_name']))) {
    echo json_encode(['error' => 'Semester name and year ID are required']);
    exit;
}

$semester_name = mysqli_real_escape_string($conn, trim($data['semester_name']));
$year_id = intval($data['year_id']);

$sql = "INSERT INTO semesters (semester_name, year_id) VALUES ('$semester_name', $year_id)";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'id' => mysqli_insert_id($conn)]);
} else {
    echo json_encode(['error' => 'Could not add semester']);
}
?>
