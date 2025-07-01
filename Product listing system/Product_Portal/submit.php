<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $specs = $_POST['specs'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO products (name, specs, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $specs, $price, $image);
    $stmt->execute();

    echo "Product submitted for approval. <a href='seller.php'>Submit another</a>";
}
?>
