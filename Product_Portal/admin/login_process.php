<?php
session_start();
include '../includes/db.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Set session variables for admin
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: index.php");
            exit;
        } else {
            header("Location: login.php?error=Invalid password");
            exit;
        }
    } else {
        header("Location: login.php?error=User not found");
        exit;
    }
} else {
    header("Location: login.php?error=Please enter username and password");
    exit;
}
?>
