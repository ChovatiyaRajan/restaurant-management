<!-- CRUD menu items -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'admin') {
  header("Location: ../auth/logout.php");
  exit();
}

// Handle Add
if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $conn->query("INSERT INTO menu_items (name, description, price) VALUES ('$name', '$desc', $price)");
}

// Handle Delete
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM menu_items WHERE id = $id");
}

// Get menu items
$items = $conn->query("SELECT * FROM menu_items");
?>

<h2>Manage Menu</h2>

<form method="POST" class="row g-2 mb-4">
  <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Item Name" required></div>
  <div class="col-md-4"><input type="text" name="description" class="form-control" placeholder="Description"></div>
  <div class="col-md-2"><input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required></div>
  <div class="col-md-2"><button name="add" class="btn btn-success w-100">Add Item</button></div>
</form>

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price ₹</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($item = $items->fetch_assoc()): ?>
    <tr>
      <td><?= $item['id'] ?></td>
      <td><?= $item['name'] ?></td>
      <td><?= $item['description'] ?></td>
      <td><?= number_format($item['price'], 2) ?></td>
      <td>
        <a href="?delete=<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
