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
                $query_track = "select * from tracking_numbers where tracking_number='$tracking_number' LIMIT 1";
                $result_track = mysqli_query($con, $query_track);
                if ($result_track == true) {
                    $query_check = "select * from tracking_numbers where tracking_number='$tracking_number' AND status_id=5 LIMIT 1";
                    $result_check = mysqli_query($con, $query_check);
                    if (mysqli_num_rows($result_check) == null) {
                        $data = new stdClass();
                        $row_track = mysqli_fetch_assoc($result_track);
                        $data->tracking_number = $row_track['tracking_number'];
                        $response->create(200, "Successful", $data);
                    }else $response->create(201, "Product already delivered!", null);
                } else $response->create(201, "Invalid Tracking Number.", null);
            } else $response->create(201, "Missing Parameter", null);
        } else $response->create(201, "Api Token not Matched", null);
    } else $response->create(201, "Missing Api Token", null);
} else $response->create(201, "Invalid Request Method", null);
echo $response->response_print();