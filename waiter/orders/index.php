<?php
require '../../config/db.php';
require '../../includes/header.php';

$sql = "SELECT o.id, t.table_no, o.status, o.created_at,
        GROUP_CONCAT(m.name SEPARATOR ', ') AS items,
        SUM(oi.quantity * m.price) AS total_amount
        FROM restaurant_orders o
        LEFT JOIN restaurant_tables t ON o.table_id = t.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN menu m ON oi.menu_id = m.id
        GROUP BY o.id
        ORDER BY o.id DESC";

$orders = $conn->query($sql);
?>


<h3 class="mb-3">All Orders</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Table</th>
      <th>Items</th>
      <th>Total</th>
      <th>Status</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $orders->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['table_no'] ?? '-' ?></td>
      <td><?= $row['items'] ?? '-' ?></td>
      <td>₹<?= $row['total_amount'] ?? '0' ?></td>
      <td><?= ucfirst($row['status']) ?></td>
      <td><?= date('d M, Y', strtotime($row['created_at'])) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<a href="/restaurant-management/waiter/dashboard.php" class="btn btn-primary mb-3">return to Dashboard</a>

<?php require '../../includes/footer.php'; ?>
