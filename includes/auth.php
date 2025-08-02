<!-- Role-based auth checker -->

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /auth/login.php");
    exit();
}
?>
