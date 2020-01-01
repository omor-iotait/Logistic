<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Response.php");
header('content-type: application/json');
$response = new Response();
$data = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["api_token"])) {
        if ($_POST['api_token'] == 'logisticToken') {
            $query = "SELECT * FROM status";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)){
                $obj = new stdClass();
                $obj->id = $row['id'];
                $obj->name = $row['name'];
                array_push($data, $obj);
            }
            $response->create(200, "Successful.", $data);
        } else$response->create(201, "Api Token not Matched", null);
    } else $response->create(201, "Missing Api Token", null);
} else$response->create(201, "Invalid Request Method", null);
echo $response->response_print();


