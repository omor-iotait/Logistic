<?php
header('content-type: application/json');
include '../includes/db.php';
$data = file_get_contents('php://input');
$json_data = json_decode($data);
$array = new stdClass();
$array1 = array();
$final_obj = new stdClass();
$tracking_list_obj = new stdClass();
if (json_last_error() === JSON_ERROR_NONE) {
    if (isset($json_data->req->tracking->api_key) || !empty(($json_data->req->tracking->api_key)))
    {
        $api_key = $json_data->req->tracking->api_key;
    }else{
        $api_key = null;
    }

    $api_key_select_query = "select * from api_keys";
    $result = mysqli_query($con, $api_key_select_query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($api_key == $row['api_key']) {
            $search = $json_data->req->tracking->tracking_number;
            $query = "SELECT * FROM events where tracking_number='" . $search . "'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $data = array();
                    $data['status'] = $row['status'];
                    $data['date_stamp'] = date('d/m/Y', $row['date_stamp']);
                    $data['remark'] = $row['remark'];
                    $data['image'] = $row['image'];
                    $data['tracking_number'] = $row['tracking_number'];
                    array_push($array1, $data);
                }
            }
            $array->status = 200;
            $array->result = $array1;
            $tracking_list_obj->tracking = $array;
            $final_obj->res = $tracking_list_obj;
            echo json_encode($final_obj, JSON_PRETTY_PRINT);
        } else {
            $array1 = null;
            $array->status = 201;
            $array->result = $array1;
            $tracking_list_obj->tracking = $array;
            $final_obj->res = $tracking_list_obj;
            echo json_encode($final_obj, JSON_PRETTY_PRINT);
        }
    }
} else {
    $array1 = null;
    $array->status = 201;
    $array->result = $array1;
    $tracking_list_obj->tracking = $array;
    $final_obj->res = $tracking_list_obj;
    echo json_encode($final_obj, JSON_PRETTY_PRINT);
}




