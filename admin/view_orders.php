<!-- See all orders -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'admin') {
  header("Location: ../auth/logout.php");
  exit();
}

// Fetch all orders with waiter info
$query = "
  SELECT o.*, u.name AS waiter_name
  FROM orders o
  JOIN users u ON o.waiter_id = u.id
  ORDER BY o.created_at DESC
";

$orders = $conn->query($query);
?>

<h2>All Orders</h2>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Waiter</th>
      <th>Table</th>
      <th>Status</th>
      <th>Created</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($order = $orders->fetch_assoc()): ?>
    <tr>
      <td><?= $order['id'] ?></td>
      <td><?= $order['waiter_name'] ?></td>
      <td><?= $order['table_number'] ?></td>
      <td><?= ucfirst($order['status']) ?></td>
      <td><?= $order['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
