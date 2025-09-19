<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Filter by semester using GET param ?semester=1st
$semester = isset($_GET['semester']) ? $_GET['semester'] : null;

if ($semester) {
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE semester = ? ORDER BY name");
    $stmt->bind_param("s", $semester);
} else {
    $stmt = $conn->prepare("SELECT * FROM subjects ORDER BY semester, name");
}

$stmt->execute();
$result = $stmt->get_result();

$subjects = [];

while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

header('Content-Type: application/json');
echo json_encode($subjects);

$stmt->close();
$conn->close();
?>
