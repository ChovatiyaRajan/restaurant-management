<!-- Orders taken by this waiter -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'waiter') {
  header("Location: ../auth/logout.php");
  exit();
}

$waiter_id = $_SESSION['user']['id'];
$orders = $conn->query("
  SELECT * FROM orders 
  WHERE waiter_id = $waiter_id 
  ORDER BY created_at DESC
");
?>

<h2>My Orders</h2>

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>Order ID</th>
      <th>Table</th>
      <th>Status</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($order = $orders->fetch_assoc()): ?>
    <tr>
      <td><?= $order['id'] ?></td>
      <td><?= $order['table_number'] ?></td>
      <td><?= ucfirst($order['status']) ?></td>
      <td><?= $order['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
