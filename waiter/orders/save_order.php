<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waiter_id = $_SESSION['user']['id'];
    $table_number = $_POST['table_number'];
    $item_ids = $_POST['items'] ?? [];

    if (empty($item_ids)) {
        die("Please select at least one menu item.");
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (waiter_id, table_number, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ii", $waiter_id, $table_number);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert items
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, item_id) VALUES (?, ?)");
    foreach ($item_ids as $item_id) {
        $stmt_item->bind_param("ii", $order_id, $item_id);
        $stmt_item->execute();
    }

    header("Location: index.php?success=Order placed successfully");
    exit;
} else {
    header("Location: place_order.php");
    exit;
}
