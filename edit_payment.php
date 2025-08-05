<?php
include 'connect.php';

$id = $_GET['id'] ?? '';
$payment = null;

// Fetch existing data
if ($id) {
    $sql = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $payment = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name     = $_POST['full_name'] ?? '';
    $course        = $_POST['course'] ?? '';
    $fee_type      = $_POST['fee_type'] ?? '';
    $amount_paid   = $_POST['amount_paid'] ?? 0;
    $payment_mode  = $_POST['payment_mode'] ?? '';
    $payment_date  = $_POST['payment_date'] ?? '';
    $payment_status = $_POST['payment_status'] ?? '';

    $update_sql = "UPDATE payments SET full_name=?, course=?, fee_type=?, amount_paid=?, payment_mode=?, payment_date=?, payment_status=? WHERE payment_id=?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "sssisssi", $full_name, $course, $fee_type, $amount_paid, $payment_mode, $payment_date, $payment_status, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: display_payment.php");
        exit();
    } else {
        echo "Update failed: " . mysqli_stmt_error($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Payment</h4>
        </div>
        <div class="card-body">
            <?php if ($payment): ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($payment['full_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="<?= htmlspecialchars($payment['course']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fee Type</label>
                    <select name="fee_type" class="form-select" required>
                        <option <?= $payment['fee_type'] == 'Tuition' ? 'selected' : '' ?>>Tuition</option>
                        <option <?= $payment['fee_type'] == 'Exam' ? 'selected' : '' ?>>Exam</option>
                        <option <?= $payment['fee_type'] == 'Library' ? 'selected' : '' ?>>Library</option>
                        <option <?= $payment['fee_type'] == 'Hostel' ? 'selected' : '' ?>>Hostel</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount Paid</label>
                    <input type="number" step="0.01" name="amount_paid" class="form-control" value="<?= $payment['amount_paid'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment Mode</label>
                    <select name="payment_mode" class="form-select" required>
                        <option <?= $payment['payment_mode'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                        <option <?= $payment['payment_mode'] == 'UPI' ? 'selected' : '' ?>>UPI</option>
                        <option <?= $payment['payment_mode'] == 'Card' ? 'selected' : '' ?>>Card</option>
                        <option <?= $payment['payment_mode'] == 'Bank Transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control" value="<?= $payment['payment_date'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select" required>
                        <option <?= $payment['payment_status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
                        <option <?= $payment['payment_status'] == 'Partially Paid' ? 'selected' : '' ?>>Partially Paid</option>
                        <option <?= $payment['payment_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Payment</button>
                <a href="display_payment.php" class="btn btn-secondary ms-2">Cancel</a>
            </form>
            <?php else: ?>
                <div class="alert alert-danger">Payment record not found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
