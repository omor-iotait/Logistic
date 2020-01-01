<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Response.php");
header('content-type: application/json');
$response = new Response();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["api_token"])) {
        if ($_POST['api_token'] == 'logisticToken') {
            if (isset($_POST["tracking_number"])) {
                $tracking_number = $_POST['tracking_number'];
                $password = md5($_POST['password']);
                $query = "SELECT * FROM tracking_numbers WHERE tracking_number='$tracking_number' AND status_id='5' LIMIT 1";
                $result = mysqli_query($con, $query);
                if ($result == false){
                    $query = "INSERT INTO request_tracking_numbers(tracking_number,status_id,driver_id,date_stamp,image_path,delivered_status) VALUES('$tracking_number','$station_prefix_id')";

                } else $response->create(201, "Product of this Tracking Number already Delivered.", null);
            } else $response->create(201, "Missing Tracking Number", null);
        } else $response->create(201, "Api Token not Matched", null);
    } else $response->create(201, "Missing Api Token", null);
} else $response->create(201, "Invalid Request Method", null);
echo $response->response_print();


