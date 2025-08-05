<?php
include 'connect.php';

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date_of_enquiry'];
    $reference = $_POST['reference'];

    $sql = "UPDATE enquiries SET 
              name='$name', 
              phone='$phone', 
              email='$email', 
              date_of_enquiry='$date', 
              reference='$reference' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: display_enquiry.php");
        exit;
    } else {
        echo "Update failed: " . $conn->error;
    }
}

$sql = "SELECT * FROM enquiries WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Enquiry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2>Edit Enquiry</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Date of Enquiry</label>
        <input type="date" name="date_of_enquiry" value="<?= htmlspecialchars($row['date_of_enquiry']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Reference</label>
        <input type="text" name="reference" value="<?= htmlspecialchars($row['reference']) ?>" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="display_enquiries.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
