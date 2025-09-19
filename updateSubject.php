<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = $data['name'];
$semester = $data['semester'];

$stmt = $conn->prepare("UPDATE subjects SET name = ?, semester = ? WHERE id = ?");
$stmt->bind_param("ssi", $name, $semester, $id);

$response = [];

if ($stmt->execute()) {
    $response['status'] = "success";
    $response['message'] = "Subject updated successfully.";
} else {
    $response['status'] = "error";
    $response['message'] = $stmt->error;
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
