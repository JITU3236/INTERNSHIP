<?php
include 'connect.php';

// Get all POST data safely
$full_name     = $_POST['full_name'] ?? '';
$email         = $_POST['email'] ?? '';
$phone         = $_POST['phone'] ?? '';
$dob           = $_POST['dob'] ?? '';
$gender        = $_POST['gender'] ?? '';
$address       = $_POST['address'] ?? '';
$qualification = $_POST['qualification'] ?? '';
$experience    = $_POST['experience'] ?? '';
$department    = $_POST['department'] ?? '';
$designation   = $_POST['designation'] ?? '';
$joining_date  = $_POST['joining_date'] ?? '';
$status        = $_POST['status'] ?? 'Inactive'; // Default to Inactive

// Handle photo upload
$photo_path = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/faculty_photos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $photo_name = uniqid() . '_' . basename($_FILES['photo']['name']);
    $target_file = $upload_dir . $photo_name;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $photo_path = $target_file;
    }
}

// Prepare and execute SQL query
$stmt = $conn->prepare("INSERT INTO faculty 
(full_name, email, phone, gender, dob, qualification, experience, department, designation, joining_date, address, status, photo)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssissssss", $full_name, $email, $phone, $gender, $dob, $qualification, $experience, $department, $designation, $joining_date, $address, $status, $photo_path);

if ($stmt->execute()) {
    echo "<script>alert('Faculty Added Successfully'); window.location.href='display_faculty.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
