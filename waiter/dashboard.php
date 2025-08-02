<?php
require '../includes/auth.php';
require '../config/db.php';
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'waiter') {
  header("Location: ../auth/logout.php");
  exit();
}

$waiter_id = $_SESSION['user']['id'];

$orderResult = $conn->query("SELECT COUNT(*) AS total_orders FROM restaurant_orders WHERE waiter_id = $waiter_id");
$orderCount = $orderResult->fetch_assoc()['total_orders'];
?>

<h2>Welcome, <?= $_SESSION['user']['name'] ?></h2>

<div class="card text-white bg-info mb-3">
  <div class="card-body">
    <h5 class="card-title">Total Orders Placed</h5>
    <p class="card-text fs-3"><?= $orderCount ?></p>
  </div>
</div>

<a href="menu/index.php" class="btn btn-outline-primary">View Food Menu</a>
<a href="orders/create.php" class="btn btn-primary">Place Order</a>
<a href="orders/index.php" class="btn btn-outline-secondary">View Orders</a>
<a href="orders/place_order.php" class="btn btn-success">Place New Order</a>

<?php include '../includes/footer.php'; ?>
