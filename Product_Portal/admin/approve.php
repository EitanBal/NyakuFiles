<?php


include '../includes/db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "UPDATE products SET status='approved' WHERE id=$id";
    $conn->query($sql);
}

header("Location: index.php");
?>
