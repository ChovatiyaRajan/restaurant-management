<!-- Admin dashboard -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'admin') {
  header("Location: ../auth/logout.php");
  exit();
}

// Count total orders
$orderResult = $conn->query("SELECT COUNT(*) AS total_orders FROM restaurant_orders");
$orderCount = $orderResult->fetch_assoc()['total_orders'];

// Count total menu items
$menuResult = $conn->query("SELECT COUNT(*) AS total_menu FROM menu_items");
$menuCount = $menuResult->fetch_assoc()['total_menu'];

// Count waiters
$waiterResult = $conn->query("SELECT COUNT(*) AS total_waiters FROM users WHERE role='waiter'");
$waiterCount = $waiterResult->fetch_assoc()['total_waiters'];
?>

<h2>Admin Dashboard</h2>
<div class="row">
  <div class="col-md-4">
    <div class="card text-white bg-success mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Orders</h5>
        <p class="card-text fs-3"><?= $orderCount ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-primary mb-3">
      <div class="card-body">
        <h5 class="card-title" style="color:white;"><a href="/restaurant-management/admin/menu/index.php" class="text-white" >Menu</a></h5>
        <p class="card-text fs-3"><?= $menuCount ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body">
        <h5 class="card-title">Waiters</h5>
        <p class="card-text fs-3"><?= $waiterCount ?></p>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
