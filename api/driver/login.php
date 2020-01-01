<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Response.php");
header('content-type: application/json');
$response = new Response();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["api_token"])) {
        if ($_POST['api_token'] == 'logisticToken') {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                $query = "SELECT * FROM drivers WHERE username='$username' AND password='$password' LIMIT 1";
                $result = mysqli_query($con, $query);
                if ($row = mysqli_fetch_assoc($result)) {
                    $data = new stdClass();
                    $data->id = $row['id'];
                    $data->name = $row['name'];
                    $data->email = $row['email'];
                    $data->contact_number = $row['contact_number'];
                    $data->vehicle_number = $row['vehicle_number'];
                    $data->vehicle_type = $row['vehicle_type'];
                    $data->zone = $row['zone'];
                    $response->create(200, "Successful Login.", $data);
                } else $response->create(201, "Username or Password Error.", null);
            } else $response->create(201, "Missing Parameter", null);
        } else $response->create(201, "Api Token not Matched", null);
    } else $response->create(201, "Missing Api Token", null);
} else $response->create(201, "Invalid Request Method", null);
echo $response->response_print();


