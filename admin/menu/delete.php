<?php
require '../../config/db.php';

$id = $_GET['id'];

// Optionally, delete image file too
$res = $conn->query("SELECT image FROM menu WHERE id = $id");
if ($row = $res->fetch_assoc()) {
  if ($row['image']) {
    $imagePath = "../../uploads/" . $row['image'];
    if (file_exists($imagePath)) {
      unlink($imagePath);
    }
  }
}

$conn->query("DELETE FROM menu WHERE id = $id");

header("Location: index.php");
exit();
?>
