<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name     = $_POST['full_name'] ?? '';
    $course        = $_POST['course'] ?? '';
    $fee_type      = $_POST['fee_type'] ?? '';
    $amount_paid   = $_POST['amount_paid'] ?? 0;
    $payment_mode  = $_POST['payment_mode'] ?? '';
    $payment_date  = $_POST['payment_date'] ?? '';
    $payment_status = $_POST['payment_status'] ?? '';

    $sql = "INSERT INTO payments (full_name, course, fee_type, amount_paid, payment_mode, payment_date, payment_status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssisss", $full_name, $course, $fee_type, $amount_paid, $payment_mode, $payment_date, $payment_status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        // ✅ Redirect to display page after successful insertion
        header("Location: display_payment.php");
        exit();
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}
?>
