<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
$id = $_POST['id'];
$query = "DELETE FROM drivers where id=$id";
mysqli_query($con,$query);
$data = "YES";
echo $data;