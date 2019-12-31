<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");

if(!empty($_POST["custom_id"])) {
    $query = "SELECT * FROM customers WHERE custom_id='" . $_POST["custom_id"] . "'";
    $result  = mysqli_query($con, $query);
    $rowcount = mysqli_num_rows($result);
    $user_count = $rowcount;
    if($user_count>0) {
        echo "<span class='status-not-available' style=' color:orangered; '><img src='../images/cros_1.png' style='height: 18px; width: 18px'>  ID already exists! </span>";
    }else{
        echo "<span class='status-available' style=' color:seagreen; '><img src='../images/tick_1.png' style='height: 18px; width: 18px'>  ID is available</span>";
    }
}
?>