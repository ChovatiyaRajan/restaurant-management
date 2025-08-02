<!-- Menu list -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'waiter') {
  header("Location: ../auth/logout.php");
  exit();
}

$items = $conn->query("SELECT * FROM menu_items");
?>

<h2>Menu Items</h2>

<div class="row">
  <?php while ($item = $items->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= $item['name'] ?></h5>
          <p class="card-text"><?= $item['description'] ?></p>
          <p class="text-muted">₹ <?= number_format($item['price'], 2) ?></p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>
