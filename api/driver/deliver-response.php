<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Response.php");
header('content-type: application/json');
$response = new Response();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["api_token"])) {
        if ($_POST['api_token'] == 'logisticToken') {
            if (isset($_POST["tracking_number"]) && $_POST['status_id']) {
                if ($_FILES['image']['tmp_name'] == TRUE) {
                    $permited = array('jpg', 'jpeg', 'png', 'gif');
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_temp = $_FILES['image']['tmp_name'];
                    $data = getimagesize($file_temp);
                    $w = $data[0] / 2;
                    $h = $data[1] / 2;
                    $div = explode('.', $file_name);
                    $file_ext = strtolower(end($div));
                    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                    $uploaded_image = "../../admin/upload/" . $unique_image;
                    if (in_array($file_ext, $permited) === true || !empty($uploaded_image)) {
                        $uploadedImage = imagecreatefromjpeg($file_temp);
                        $oldw = imagesx($uploadedImage);
                        $oldh = imagesy($uploadedImage);
                        $temp = imagecreatetruecolor($w, $h);
                        imagecopyresampled($temp, $uploadedImage, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
                        imagejpeg($temp, "../../admin/upload/" . $unique_image);
                        $tracking_number = $_POST['tracking_number'];
                        $status_id = $_POST['status_id'];
                        $driver_id = $_POST['driver_id'];
                        $date = time();
                        $query_track = "SELECT * FROM tracking_numbers WHERE tracking_number='$tracking_number' LIMIT 1";
                        $result_track = mysqli_query($con, $query_track);
                        $row_track = mysqli_fetch_assoc($result_track);
                        $tracking_number_id = $row_track['id'];
                        $query_track_status = "SELECT * FROM tracking_status WHERE tracking_number_id=$tracking_number_id AND status_id=5 LIMIT 1";
                        $result_track_status = mysqli_query($con, $query_track_status);
                        if (mysqli_num_rows($result_track_status) == null) {
                            $query_driver = "INSERT INTO driver_requests(tracking_number_id,status_id,driver_id,date_stamp,image_path) VALUES('$tracking_number_id','$status_id','$driver_id','$date','$uploaded_image')";
                            $con->query($query_driver);
                            $response->create(200,  "Successful", null);
                        } else $response->create(201,  "Product already delivered.", null);
                    } else $response->create(201, "You can upload only image.", null);
                } else $response->create(201, "Image not Set.", null);
            } else $response->create(201, "Missing Tracking Number", null);
        } else $response->create(201, "Api Token not Matched", null);
    } else $response->create(201, "Missing Api Token", null);
} else $response->create(201, "Invalid Request Method", null);
echo $response->response_print();


