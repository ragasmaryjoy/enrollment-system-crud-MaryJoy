Student Enrollment System


Open your browser and go to:
http://localhost/phpmyadmin

Create a new database:
Name it (enrollments)

Import the SQL file:

Click the database you just created

Go to the Import tab

Click Choose File and select the enrollment_db.sql file from your project folder

Click Go to import

#configure PHP

<?php
$host = "localhost";
$username = "root";
$password = ""; // Default for XAMPP/WAMP
$database = "enrollments";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

http://localhost/student-enrollment-system/


MARY JOY M. RAGAS 3B

