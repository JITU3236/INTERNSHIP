<?php
session_start();
include 'connect.php'; // Ensure this connects properly to your database

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    echo "<script>alert('Username and Password are required.'); window.location.href='login.html';</script>";
    exit;
}

// Prepare and execute the SQL statement
$sql = "SELECT * FROM ADMIN WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    // Login successful
    $_SESSION['username'] = $username;
    header("Location: login.html"); // change to your dashboard/home page
    exit;
} else {
    echo "<script>alert('Invalid credentials'); window.location.href='index.php';</script>";
    exit;
}
?>
