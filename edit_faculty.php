<?php
include 'connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

// Fetch faculty data
$stmt = $conn->prepare("SELECT * FROM faculty WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Faculty not found.");
}
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $department = $_POST['department'] ?? '';
    $qualification = $_POST['qualification'] ?? '';
    $joining_date = $_POST['joining_date'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $photo = $row['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $photo = basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo);
    }

    $stmt = $conn->prepare("UPDATE faculty SET name=?, email=?, phone=?, dob=?, gender=?, department=?, qualification=?, joining_date=?, experience=?, salary=?, photo=? WHERE id=?");
    $stmt->bind_param("sssssssssssi", $name, $email, $phone, $dob, $gender, $department, $qualification, $joining_date, $experience, $salary, $photo, $id);

    if ($stmt->execute()) {
        header("Location: display_faculty.php");
        exit;
    } else {
        echo "Update failed: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Faculty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Edit Faculty</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
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
        <label>Department</label>
        <input type="text" name="department" value="<?= htmlspecialchars($row['department']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Qualification</label>
        <input type="text" name="qualification" value="<?= htmlspecialchars($row['qualification']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Joining Date</label>
        <input type="date" name="joining_date" value="<?= htmlspecialchars($row['joining_date']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Experience (Years)</label>
        <input type="number" name="experience" value="<?= htmlspecialchars($row['experience']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Salary</label>
        <input type="number" name="salary" step="0.01" value="<?= htmlspecialchars($row['salary']) ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Photo</label>
        <input type="file" name="photo" class="form-control">
        <?php if (!empty($row['photo'])): ?>
          <small>Current: <a href="uploads/<?= htmlspecialchars($row['photo']) ?>" target="_blank"><?= htmlspecialchars($row['photo']) ?></a></small>
        <?php endif; ?>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Update Faculty</button>
    <a href="display_faculty.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
