<?php
require 'dbcon.php';

$name = $_POST['student_id'];
$price = $_POST['name'];
$stock = $_POST['program_id'];



$stmt = $pdo->prepare('INSERT INTO student (stud_id, name, prog_id) VALUES (?, ?, ?)');
$stmt->execute([$name, $price, $stock]);

$product_id = $pdo->lastInsertId();


$stmt = $pdo->prepare('INSERT INTO expiration (product_id, expiration_date) VALUES (?, ?)');
$stmt->execute([$product_id, $expiration_date]);

header('Location: student.php');
exit;
?>