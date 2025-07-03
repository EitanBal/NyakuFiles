<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

// Get pending products
$sql = "SELECT * FROM products WHERE status='pending'";
$result = $conn->query($sql);

// Get all orders
$sqlOrders = "
    SELECT o.*, p.name AS product_name
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    ORDER BY o.created_at DESC
";
$resultOrders = $conn->query($sqlOrders);

?>
<a href="logout.php" class="btn btn-danger btn-sm float-end">Logout</a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard - Pending Products & Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Keep your existing styles from your question unchanged... */
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }
        .container {
            margin-top: 60px;
            background: #fff;
            color: #333;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.3);
            padding: 2rem 2.5rem;
        }
        h2 {
            font-weight: 700;
            color: #4a3aff;
            margin-bottom: 1.8rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }
        table {
            border-collapse: separate !important;
            border-spacing: 0 0.75rem;
            width: 100%;
            background: transparent;
        }
        thead th {
            background: #4a3aff;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none !important;
            padding: 0.75rem 1rem;
            border-radius: 8px 8px 0 0;
            user-select: none;
        }
        tbody tr {
            background: #f7f7ff;
            border-radius: 10px;
            transition: box-shadow 0.3s ease;
            cursor: default;
            box-shadow: 0 4px 6px rgba(118, 75, 162, 0.1);
        }
        tbody tr:hover {
            box-shadow: 0 12px 25px rgba(118, 75, 162, 0.25);
            transform: translateY(-3px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        tbody td {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            border: none !important;
            font-weight: 500;
        }
        tbody td img {
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(74, 58, 255, 0.2);
            transition: transform 0.3s ease;
            width: 100px;
            height: 70px;
        }
        tbody td img:hover {
            transform: scale(1.05);
        }
        .btn-success {
            background: linear-gradient(135deg, #4caf50, #81c784);
            border: none;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(76, 175, 80, 0.4);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #388e3c, #66bb6a);
            box-shadow: 0 10px 20px rgba(56, 142, 60, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pending Products</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specs</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['specs']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($row['price'], 2)) ?></td>
                            <td>
                                <img src="../<?= $row['image'] ?>" alt="Product Image" />
                            </td>
                            <td>
                                <form action="approve.php" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="reject.php" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                <input type="text" name="reason" placeholder="Reason" class="form-control mb-2" />
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                            </td>
                            

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center fs-5 text-muted mt-4">No pending products.</p>
        <?php endif; ?>

        <hr class="my-5" />

        <h2>Recent Orders</h2>

        <?php if ($resultOrders->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Buyer Name</th>
                        <th>Buyer Phone</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $resultOrders->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['product_name'] ?? 'Unknown') ?></td>
                            <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                            <td><?= htmlspecialchars($order['buyer_phone']) ?></td>
                            <td><?= htmlspecialchars(strtoupper($order['payment_method'])) ?></td>
                            <td><?= htmlspecialchars($order['transaction_id'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center fs-5 text-muted mt-4">No orders placed yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
