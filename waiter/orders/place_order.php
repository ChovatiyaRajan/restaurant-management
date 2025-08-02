<?php
session_start();
require_once('../../config/db.php');
require_once('../../includes/auth.php');

$waiter_id = $_SESSION['user']['id'];

$sql = "SELECT o.id, t.table_no, o.order_time
        FROM restaurant_orders o
        LEFT JOIN restaurant_tables t ON o.table_id = t.id
        WHERE o.waiter_id = $waiter_id
        ORDER BY o.order_time DESC";

$orders = $conn->query($sql);
?>

<?php include('../../includes/header.php'); ?>
<div class="container mt-5">
    <h2>My Orders</h2>
    <a href="add_order.php" class="btn btn-primary mb-3">+ Add New Order</a>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Order placed successfully!</div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Table</th>
                <th>Date/Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $orders->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['table_no'] ?? '-' ?></td>
                    <td><?= date('d M Y, H:i', strtotime($row['order_time'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include('../../includes/footer.php'); ?>
