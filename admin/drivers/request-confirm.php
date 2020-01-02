<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}

$id = $_GET['id'];
$query_request = "select * from driver_requests where id='$id' LIMIT 1";
$result_request = mysqli_query($con, $query_request);
$row_request = mysqli_fetch_assoc($result_request);
$tracking_number_id = $row_request['tracking_number_id'];
$status_id = $row_request['status_id'];
$date = $row_request['date_stamp'];
$uploaded_image = $row_request['image_path'];
$remark = $row_request['remark'];

$query_tracking_status = "INSERT INTO tracking_status(tracking_number_id,status_id,date_stamp,image_path,remark) VALUES('$tracking_number_id','$status_id','$date','$uploaded_image','$remark')";
if ($con->query($query_tracking_status) === TRUE) {
    $query_request_update = "UPDATE driver_requests SET deliver_status=2  WHERE id='$id'";
    if ($con->query($query_request_update) == TRUE){
        $_SESSION['success'] = "New Tracking Status created successfully";
        header("location:".BASE_URL."admin/drivers/request.php");
        exit(0);
    }else{
        $last_id = mysqli_insert_id($con);
        $query = "DELETE FROM tracking_status where id=$last_id";
        mysqli_query($con,$query);
        $message = "Error Tracking status not Updated.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("location: ".$_SERVER['HTTP_REFERER']);
        exit(0);
    }

}else{
    $message = "Error Tracking status not Updated.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("location: ".$_SERVER['HTTP_REFERER']);
    exit(0);
}