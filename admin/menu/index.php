<?php
require '../../config/db.php';
require '../../includes/header.php';

$result = $conn->query("SELECT * FROM menu ORDER BY id DESC");
?>

<div class="d-flex justify-content-between mb-3">
  <h3>Food Menu</h3>
  <a href="add.php" class="btn btn-success">Add Item</a>
</div>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Category</th>
      <th>Price</th>
      <th>Description</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td>₹<?= number_format($row['price'], 2) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
          <?php if ($row['image']) : ?>
            <img src="/restaurant-management/uploads/<?= $row['image'] ?>" width="60" height="50">
          <?php endif; ?>
        </td>
        <td>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<div>
    <a href="/restaurant-management/admin/dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<?php require '../../includes/footer.php'; ?>
