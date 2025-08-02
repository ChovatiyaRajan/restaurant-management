<?php
require '../../config/db.php';
require '../../includes/header.php';

$result = $conn->query("SELECT * FROM menu ORDER BY created_at DESC");
?>

<h3 class="mb-4">Food Menu</h3>

<div class="row">
  <?php while ($row = $result->fetch_assoc()): ?>
  <div class="col-md-4 mb-4">
    <div class="card h-100">
      <?php if ($row['image']): ?>
        <img src="/restaurant-management/uploads/<?= $row['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
      <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?= $row['name'] ?></h5>
        <p class="card-text"><?= $row['description'] ?></p>
        <p class="fw-bold text-success">₹<?= $row['price'] ?></p>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>

<?php require '../../includes/footer.php'; ?>
