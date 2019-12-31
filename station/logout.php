<?php
session_start();
unset($_SESSION['station']);
unset($_SESSION['id']);
unset($_SESSION['station-login']);

header("Location: login.php");
exit;
?>