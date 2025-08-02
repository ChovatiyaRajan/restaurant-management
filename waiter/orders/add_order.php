<?php
session_start();
require_once('../../config/db.php');
require_once('../../includes/auth.php');

$waiter_id = $_SESSION['user']['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'];
    $menu_ids = $_POST['menu_id'];
    $quantities = $_POST['quantity'];

    // Insert into restaurant_orders
    $conn->query("INSERT INTO restaurant_orders (waiter_id, table_id, order_time, status) VALUES ($waiter_id, $table_id, NOW(), 'pending')");
    $order_id = $conn->insert_id;

    // Insert items
    foreach ($menu_ids as $index => $menu_id) {
        $quantity = (int)$quantities[$index];
        if ($quantity > 0) {
            $conn->query("INSERT INTO order_items (order_id, menu_id, quantity) VALUES ($order_id, $menu_id, $quantity)");
        }
    }

    header("Location: index.php?success=1");
    exit;
}

// Fetch table list and menu list
$tables = $conn->query("SELECT * FROM restaurant_tables");
$menu = $conn->query("SELECT * FROM menu");
?>

<?php include('../../includes/header.php'); ?>
<div class="container mt-5">
    <h2>Place New Order</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Table</label>
            <select name="table_id" class="form-select" required>
                <option value="">-- Select Table --</option>
                <?php while ($row = $tables->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">Table <?= $row['table_no'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <h5>Select Items</h5>
        <?php while ($item = $menu->fetch_assoc()): ?>
            <div class="mb-2 row">
                <div class="col-md-6"><?= $item['name'] ?> (₹<?= $item['price'] ?>)</div>
                <div class="col-md-2">
                    <input type="hidden" name="menu_id[]" value="<?= $item['id'] ?>">
                    <input type="number" name="quantity[]" class="form-control" min="0" placeholder="Qty">
                </div>
            </div>
        <?php endwhile; ?>

        <button type="submit" class="btn btn-success mt-3">Place Order</button>
        <a href="index.php" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
<?php include('../../includes/footer.php'); ?>
