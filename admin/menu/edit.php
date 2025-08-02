<?php
require '../../config/db.php';
require '../../includes/header.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM menu WHERE id = $id");
$item = $result->fetch_assoc();

if (!$item) {
  echo "Item not found!";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $image = $item['image'];

  // Update image if new uploaded
  if ($_FILES['image']['name']) {
    $imgName = time() . '_' . $_FILES['image']['name'];
    $targetPath = "../../uploads/" . $imgName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    $image = $imgName;
  }

  $stmt = $conn->prepare("UPDATE menu SET name=?, category=?, price=?, description=?, image=? WHERE id=?");
  $stmt->bind_param("ssdssi", $name, $category, $price, $description, $image, $id);
  $stmt->execute();

  header("Location: index.php");
  exit();
}
?>

<h3 class="mb-3">Edit Menu Item</h3>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-2">
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']) ?>" required>
  </div>
  <div class="mb-2">
    <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($item['category']) ?>" required>
  </div>
  <div class="mb-2">
    <input type="number" step="0.01" name="price" class="form-control" value="<?= $item['price'] ?>" required>
  </div>
  <div class="mb-2">
    <textarea name="description" class="form-control"><?= htmlspecialchars($item['description']) ?></textarea>
  </div>
  <div class="mb-3">
    <?php if ($item['image']) : ?>
      <img src="/restaurant-management/uploads/<?= $item['image'] ?>" width="80" height="60"><br>
    <?php endif; ?>
    <input type="file" name="image" class="form-control mt-2">
  </div>
  <button class="btn btn-primary">Update Item</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>

<?php require '../../includes/footer.php'; ?>
