<?php
include 'connect.php';

// Get all POST data safely
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$dob = $_POST['dob'] ?? '';
$gender = $_POST['gender'] ?? '';
$address = $_POST['address'] ?? '';
$course_applied = $_POST['course_applied'] ?? '';
$admission_date = $_POST['admission_date'] ?? '';
$status = $_POST['status'] ?? 'Pending';
$guardian_name = $_POST['guardian_name'] ?? '';
$qualification = $_POST['qualification'] ?? '';
$documents_submitted = $_POST['documents_submitted'] ?? '';
$payment_status = $_POST['payment_status'] ?? 'Unpaid';
$fee_amount = $_POST['fee_amount'] ?? null;

// Handle photo upload
$photo_name = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $photo_name = basename($_FILES['photo']['name']);
    $target_file = $upload_dir . $photo_name;
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
}

// Prepare and execute SQL query
$stmt = $conn->prepare("INSERT INTO admissions (full_name, email, phone, dob, gender, address, course_applied, admission_date, status, guardian_name, qualification, documents_submitted, payment_status, fee_amount, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssss", $full_name, $email, $phone, $dob, $gender, $address, $course_applied, $admission_date, $status, $guardian_name, $qualification, $documents_submitted, $payment_status, $fee_amount, $photo_name);

if ($stmt->execute()) {
    echo "<script>alert('Admission Submitted Successfully'); window.location.href='display_admission.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
