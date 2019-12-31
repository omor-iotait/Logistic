<?php
session_start();
unset($_SESSION['customer']);
unset($_SESSION['customer-login']);

header("Location: login.php");
exit;
?>