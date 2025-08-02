<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'waiter') {
  header("Location: ../login.php");
  exit();
}
?>

<?php
require '../../config/db.php';
require '../../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $table = (int)$_POST['table'];
  $items = $_POST['items']; // Array of menu item IDs
  $quantities = $_POST['quantity']; // Array of quantities

  $waiter_id = $_SESSION['user_id']; // Waiter ID from session

  // Step 1: Insert into orders table
  $stmt = $conn->prepare("INSERT INTO orders (waiter_id, table_number) VALUES (?, ?)");
  $stmt->bind_param("ii", $waiter_id, $table);
  $stmt->execute();

  $order_id = $conn->insert_id; // Get the newly inserted order ID

  // Step 2: Insert items into order_items table

  foreach ($items as $index => $itemId) {
    $quantity = (int)$quantities[$index];
    if ($quantity <= 0) continue;

    // Get item price
    $res = $conn->query("SELECT price FROM menu WHERE id = $itemId");
    $menuItem = $res->fetch_assoc();
    $price = $menuItem['price'];

    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmtItem->bind_param("iiid", $order_id, $itemId, $quantity, $price);
    $stmtItem->execute();
  }

  header("Location: index.php?success=1");
  exit();
}

$menu = $conn->query("SELECT * FROM menu");
?>

<h3 class="mb-3">Place Order</h3>
<form method="POST">
  <div class="mb-3">
    <label>Table No.</label>
    <input type="number" name="table" class="form-control" required />
  </div>

  <div class="mb-3">
    <label>Select Food Items:</label>
    <?php while ($item = $menu->fetch_assoc()): ?>
      <div class="mb-2 border p-2 rounded">
        <input type="hidden" name="items[]" value="<?= $item['id'] ?>">
        <strong><?= $item['name'] ?> (₹<?= $item['price'] ?>)</strong><br />
        Quantity:
        <input type="number" name="quantity[]" value="0" min="0" class="form-control w-25 d-inline" />
      </div>
    <?php endwhile; ?>
  </div>

  <button class="btn btn-success">Submit Order</button>
</form>

<?php require '../../includes/footer.php'; ?>
