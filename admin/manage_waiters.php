<!-- CRUD waiters -->

<?php 
require '../includes/auth.php'; 
require '../config/db.php'; 
include '../includes/header.php';

if ($_SESSION['user']['role'] !== 'admin') {
  header("Location: ../auth/logout.php");
  exit();
}

// Handle Add Waiter
if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'waiter')");
  $stmt->bind_param("sss", $name, $email, $password);
  $stmt->execute();
}

// Handle Delete Waiter
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM users WHERE id = $id AND role = 'waiter'");
}

// Fetch Waiters
$waiters = $conn->query("SELECT * FROM users WHERE role = 'waiter'");
?>

<h2>Manage Waiters</h2>

<form method="POST" class="row g-2 mb-4">
  <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Waiter Name" required></div>
  <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="col-md-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
  <div class="col-md-2"><button name="add" class="btn btn-success w-100">Add Waiter</button></div>
</form>

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $waiters->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td>
        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this waiter?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
