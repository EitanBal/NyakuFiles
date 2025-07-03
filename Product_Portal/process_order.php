<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $buyer_name = $conn->real_escape_string($_POST['buyer_name']);
    $buyer_phone = $conn->real_escape_string($_POST['buyer_phone']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $transaction_id = isset($_POST['transaction_id']) ? $conn->real_escape_string($_POST['transaction_id']) : null;

    // Basic validation
    if (!$product_id || !$buyer_name || !$buyer_phone || !$payment_method) {
        die('Missing required fields.');
    }

    $sql = "INSERT INTO orders (product_id, buyer_name, buyer_phone, payment_method, transaction_id)
            VALUES ('$product_id', '$buyer_name', '$buyer_phone', '$payment_method', " . 
            ($transaction_id ? "'$transaction_id'" : "NULL") . ")";

    if ($conn->query($sql)) {
        $order_id = $conn->insert_id;
        header("Location: thank_you.php?order_id=$order_id");
        exit;
    } else {
        die("Database error: " . $conn->error);
    }
} else {
    header('Location: index.php');
    exit;
}
