<?php
$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

// Check if subject has enrolled students
$check = $conn->prepare("SELECT COUNT(*) FROM enrollments WHERE subject_id = ?");
$check->bind_param("i", $id);
$check->execute();
$check->bind_result($count);
$check->fetch();
$check->close();

$response = [];

if ($count > 0) {
    $response['status'] = "error";
    $response['message'] = "Cannot delete: Students are enrolled in this subject.";
} else {
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['status'] = "success";
        $response['message'] = "Subject deleted successfully.";
    } else {
        $response['status'] = "error";
        $response['message'] = $stmt->error;
    }

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
