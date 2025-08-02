<!-- Redirect to login or dashboard -->

<?php
session_start();
if (isset($_SESSION['user'])) {
  $role = $_SESSION['user']['role'];
  if ($role == 'admin') {
    header("Location: admin/dashboard.php");
  } else {
    header("Location: waiter/dashboard.php");
  }
  exit();
} else {
  header("Location: auth/login.php");
  exit();
}
?>
