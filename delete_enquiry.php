<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM enquiries WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: display_enquiry.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID";
}
?>
