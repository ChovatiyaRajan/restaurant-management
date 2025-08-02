<!-- Order placing page -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'waiter') {
  header("Location: ../auth/logout.php");
  exit();
}

$menu = $conn->query("SELECT * FROM menu_items");

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $table_number = $_POST['table_number'];
  $waiter_id = $_SESSION['user']['id'];
  $conn->query("INSERT INTO orders (waiter_id, table_number) VALUES ($waiter_id, $table_number)");
  $order_id = $conn->insert_id;

  foreach ($_POST['items'] as $menu_id => $qty) {
    if ($qty > 0) {
      $conn->query("INSERT INTO order_items (order_id, menu_id, quantity) VALUES ($order_id, $menu_id, $qty)");
    }
  }

  echo "<div class='alert alert-success'>Order placed successfully!</div>";
}
?>

<h2>Take Order</h2>

<form method="POST">
  <div class="mb-3">
    <label class="form-label">Table Number</label>
    <input type="number" name="table_number" class="form-control" required />
  </div>

  <h5>Select Menu Items</h5>
  <?php while ($item = $menu->fetch_assoc()): ?>
    <div class="mb-2 row">
      <div class="col-md-6"><?= $item['name'] ?> (₹ <?= number_format($item['price'], 2) ?>)</div>
      <div class="col-md-2"><input type="number" name="items[<?= $item['id'] ?>]" class="form-control" placeholder="Qty" min="0"></div>
    </div>
  <?php endwhile; ?>

  <button class="btn btn-primary mt-3">Place Order</button>
</form>

<?php include '../includes/footer.php'; ?>
