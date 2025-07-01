<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $conn->query("UPDATE products SET status = 'approved' WHERE id = $id");
    header("Location: index.php");
}
?>
