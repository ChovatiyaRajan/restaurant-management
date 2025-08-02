<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user'])) {
  header("Location: ../auth/login.php");
  exit();
}
?>