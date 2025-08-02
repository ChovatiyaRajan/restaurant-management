<?php
require '../../config/db.php';
require '../../includes/header.php';

$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
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
      <td><?= $row['table_no'] ?></td>
      <td><?= $row['items'] ?></td>
      <td>₹<?= $row['total_amount'] ?></td>
      <td><?= ucfirst($row['status']) ?></td>
      <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php require '../../includes/footer.php'; ?>
