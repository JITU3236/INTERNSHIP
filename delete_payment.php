<?php
include 'connect.php';

$id = $_GET['id'] ?? '';

if ($id) {
    $sql = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: display_payment.php");
        exit();
    } else {
        echo "Delete failed: " . mysqli_stmt_error($stmt);
    }
} else {
    echo "Invalid ID";
}
?>
