<?php
include 'connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Use a prepared statement to avoid SQL injection
    $stmt = $conn->prepare("DELETE FROM admissions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: display_admission.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid ID";
}

$conn->close();
?>
