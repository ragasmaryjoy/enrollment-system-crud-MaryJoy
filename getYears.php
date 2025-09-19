<?php
header('Content-Type: application/json');
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM years");
$years = [];
while ($row = mysqli_fetch_assoc($result)) {
    $years[] = $row;
}
echo json_encode($years);
?>
