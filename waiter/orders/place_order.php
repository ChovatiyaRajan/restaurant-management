<?php
session_start();
require_once('../../config/db.php');
require_once('../../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waiter_id = $_SESSION['user']['id'];
    $table_number = $_POST['table_number'];
    $created_at = date('Y-m-d H:i:s');

    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (waiter_id, table_number, status, created_at) VALUES (?, ?, 'pending', ?)");
    $stmt->bind_param("iis", $waiter_id, $table_number, $created_at);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert into order_items table
    foreach ($_POST['items'] as $item_id => $qty) {
        if ($qty > 0) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $order_id, $item_id, $qty);
            $stmt->execute();
        }
    }

    header('Location: my_orders.php?success=1');
    exit();
}

// Fetch menu items
$menu_items = $conn->query("SELECT * FROM menu_items WHERE is_available = 1");
?>

<?php include('../../includes/header.php'); ?>
<div class="container mt-5">
    <h2>Place New Order</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="table_number" class="form-label">Table Number</label>
            <input type="number" name="table_number" class="form-control" required>
        </div>

        <h4>Menu</h4>
        <?php while ($item = $menu_items->fetch_assoc()) : ?>
            <div class="mb-2">
                <strong><?= htmlspecialchars($item['name']) ?></strong> - ₹<?= $item['price'] ?>
                <input type="number" name="items[<?= $item['id'] ?>]" min="0" placeholder="Qty" class="form-control w-25 d-inline ms-2">
            </div>
        <?php endwhile; ?>

        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>
</div>
<?php include('../../includes/footer.php'); ?>
