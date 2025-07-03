<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $reason = $conn->real_escape_string($_POST['reason']);

    $sql = "UPDATE products SET status='rejected', rejection_reason='$reason' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: index.php?msg=rejected");
    } else {
        echo "Error: " . $conn->error;
    }
}

?>