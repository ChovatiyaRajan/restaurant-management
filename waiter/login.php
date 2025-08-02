<?php
session_start();
require '../config/db.php'; // adjust path if needed

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'waiter'");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['role'] = $user['role'];
      header("Location: orders/dashboard.php");
      exit();
    } else {
      $error = "Invalid password";
    }
  } else {
    $error = "Waiter not found or not authorized";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Waiter Login</title>
  <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body class="p-4">
  <h2>Waiter Login</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required />
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required />
    </div>
    <button class="btn btn-primary">Login</button>
  </form>
</body>
</html>
