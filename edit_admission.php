<?php
include 'connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

// Fetch existing admission data
$stmt = $conn->prepare("SELECT * FROM admissions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Record not found or database error.");
}
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $course_applied = $_POST['course_applied'] ?? '';
    $admission_date = $_POST['admission_date'] ?? '';
    $status = $_POST['status'] ?? '';
    $guardian_name = $_POST['guardian_name'] ?? '';
    $qualification = $_POST['qualification'] ?? '';
    $documents_submitted = $_POST['documents_submitted'] ?? '';
    $payment_status = $_POST['payment_status'] ?? '';
    $fee_amount = $_POST['fee_amount'] ?? '';
    $photo_name = $row['photo']; // Keep previous photo if new not uploaded

    // Photo upload (optional)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $photo_name = basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $photo_name;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    }

    $stmt = $conn->prepare("UPDATE admissions SET full_name=?, email=?, phone=?, dob=?, gender=?, address=?, course_applied=?, admission_date=?, status=?, guardian_name=?, qualification=?, documents_submitted=?, payment_status=?, fee_amount=?, photo=? WHERE id=?");
    $stmt->bind_param("sssssssssssssssi", $full_name, $email, $phone, $dob, $gender, $address, $course_applied, $admission_date, $status, $guardian_name, $qualification, $documents_submitted, $payment_status, $fee_amount, $photo_name, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: display_admission.php");
        exit;
    } else {
        echo "Update failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Admission</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Edit Admission</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($row['full_name']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Date of Birth</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($row['dob']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Gender</label>
        <select name="gender" class="form-control" required>
          <option <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
          <option <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
          <option <?= $row['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" required><?= htmlspecialchars($row['address']) ?></textarea>
      </div>
      <div class="col-md-6 mb-3">
        <label>Course Applied</label>
        <input type="text" name="course_applied" value="<?= htmlspecialchars($row['course_applied']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Admission Date</label>
        <input type="date" name="admission_date" value="<?= htmlspecialchars($row['admission_date']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
          <option <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
          <option <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <label>Guardian Name</label>
        <input type="text" name="guardian_name" value="<?= htmlspecialchars($row['guardian_name']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Qualification</label>
        <input type="text" name="qualification" value="<?= htmlspecialchars($row['qualification']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Documents Submitted</label>
        <input type="text" name="documents_submitted" value="<?= htmlspecialchars($row['documents_submitted']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Payment Status</label>
        <select name="payment_status" class="form-control" required>
          <option <?= $row['payment_status'] == 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
          <option <?= $row['payment_status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <label>Fee Amount</label>
        <input type="number" step="0.01" name="fee_amount" value="<?= htmlspecialchars($row['fee_amount']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Photo</label>
        <input type="file" name="photo" class="form-control">
        <?php if (!empty($row['photo'])): ?>
          <small>Current: <a href="uploads/<?= htmlspecialchars($row['photo']) ?>" target="_blank"><?= htmlspecialchars($row['photo']) ?></a></small>
        <?php endif; ?>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Admission</button>
    <a href="display_admission.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
