<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$semester = $data['semester'];

$stmt = $conn->prepare("INSERT INTO subjects (name, semester) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $semester);

$response = [];

if ($stmt->execute()) {
    $response['status'] = "success";
    $response['message'] = "Subject added successfully.";
} else {
    $response['status'] = "error";
    $response['message'] = $stmt->error;
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
