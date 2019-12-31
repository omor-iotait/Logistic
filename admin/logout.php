<?php
session_start();
unset($_SESSION['customer']);
unset($_SESSION['admin-login']);
//session_destroy();

header("Location: login.php");
exit;
?>