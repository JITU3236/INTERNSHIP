<?php
include 'connect.php';

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$date_of_enquiry = $_POST['date_of_enquiry'] ?? '';
$reference = $_POST['reference'] ?? '';

$stmt = $conn->prepare("INSERT INTO enquiries (name, phone, email, date_of_enquiry, reference) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $phone, $email, $date_of_enquiry, $reference);

if ($stmt->execute()) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='enquiry.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
