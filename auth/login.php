<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if ($password === $user['password']) {
      $_SESSION['user'] = $user;
      if ($user['role'] == 'admin') {
        header("Location: /restaurant-management/admin/dashboard.php");
      } else {
        header("Location: /restaurant-management/waiter/dashboard.php");

      }
      exit();
    }
  }
  $error = "Invalid email or password";
}
?>

<?php include '../includes/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-4">
    <h3 class="mb-3">Login</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
      <div class="mb-2">
        <input type="email" name="email" class="form-control" placeholder="Email" required />
      </div>
      <div class="mb-2">
        <input type="password" name="password" class="form-control" placeholder="Password" required />
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
