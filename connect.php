<?php
$host = 'localhost';
$user = 'root';
$password = ''; // XAMPP default
$database = 'ADMIN'; // ✅ change this to your database name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
