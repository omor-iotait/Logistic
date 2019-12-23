<?php
$con=new mysqli("localhost","root","", "db_logistic");
//$con=new mysqli("localhost","musltwlf_omor","123@123z", "musltwlf_logistic");
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>