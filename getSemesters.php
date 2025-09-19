<?php
header('Content-Type: application/json');
include 'db.php';

$sql = "SELECT semesters.id, semesters.semester_name, years.id AS year_id, years.year_name
        FROM semesters
        JOIN years ON semesters.year_id = years.id";

$result = mysqli_query($conn, $sql);
$semesters = [];
while ($row = mysqli_fetch_assoc($result)) {
    $semesters[] = $row;
}

echo json_encode($semesters);
?>
