<?php
require '../../config/db.php';
require '../../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $image = '';

  // Image upload
  if ($_FILES['image']['name']) {
    $imgName = time() . '_' . $_FILES['image']['name'];
    $targetPath = "../../uploads/" . $imgName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    $image = $imgName;
  }

  $stmt = $conn->prepare("INSERT INTO menu (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdss", $name, $category, $price, $description, $image);
  $stmt->execute();

  header("Location: index.php");
  exit();
}
?>

<h3 class="mb-3">Add Menu Item</h3>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-2">
    <input type="text" name="name" class="form-control" placeholder="Food Name" required>
  </div>
  <div class="mb-2">
    <input type="text" name="category" class="form-control" placeholder="Category (e.g., Starter, Main Course)" required>
  </div>
  <div class="mb-2">
    <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
  </div>
  <div class="mb-2">
    <textarea name="description" class="form-control" placeholder="Description"></textarea>
  </div>
  <div class="mb-3">
    <input type="file" name="image" class="form-control">
  </div>
  <button class="btn btn-success">Add Item</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>

<?php require '../../includes/footer.php'; ?>
