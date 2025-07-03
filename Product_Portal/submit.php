<?php
include 'includes/db.php';

$name = $_POST['name'];
$specs = $_POST['specs'];
$price = $_POST['price'];

$target_dir = "uploads/";
$imageName = basename($_FILES["image"]["name"]);
$target_file = $target_dir . uniqid() . "_" . $imageName;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO products (name, specs, price, image, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssds", $name, $specs, $price, $target_file);
    $stmt->execute();
    header("Location: seller.php?success=1");
} else {
    echo "Error uploading file.";
}
?>
