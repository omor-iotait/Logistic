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
    if (isset($json_data->req->tracking_list->api_key) || !empty(($json_data->req->tracking_list->api_key)))
    {
        $api_key = $json_data->req->tracking_list->api_key;
    }else{
        $api_key = null;
    }
    $api_key_select_query = "select * from api_keys";
    $result = mysqli_query($con, $api_key_select_query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($api_key == "adscedrt19ApicsKsdEz44dcYTsdfEcdf5nSfs60lT")
        {
            $query = "select * from event_tests GROUP BY tracking_number";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $track = $row['tracking_number'];
                $query1 = "SELECT COUNT(*) as total FROM event_tests WHERE tracking_number='" . $track . "' ORDER BY date_stamp desc";
                $result1 = mysqli_query($con, $query1);
                $data = mysqli_fetch_assoc($result1);
                $query2 = "SELECT * FROM event_tests WHERE tracking_number='" . $track . "' ORDER BY date_stamp desc";
                $result2 = mysqli_query($con, $query2);
                $row1 = mysqli_fetch_assoc($result2);
                $flag = 0;
                for ($i = 0; $i <= $data['total']; $i++) {
                    if ($flag == 0) {
                        $data1 = array();
                        $data1['status'] = $row1['status'];
                        $data1['date_stamp'] = date('d/m/Y', $row1['date_stamp']);
                        $data1['image'] = $row1['image'];
                        $data1['remark'] = $row1['remark'];
                        $data1['tracking_number'] = $row1['tracking_number'];
                        array_push($array1,$data1);
                        $flag = 1;
                    }
                }
            }
            $array->status = 200;
            $array->result = $array1;
            $tracking_list_obj->tracking_list = $array;
            $final_obj->res = $tracking_list_obj;
            echo json_encode($final_obj, JSON_PRETTY_PRINT);
        }else
        {
            $array1 = null;
            $array->status = 201;
            $array->result = $array1;
            $tracking_list_obj->tracking_list = $array;
            $final_obj->res = $tracking_list_obj;
            echo json_encode($final_obj, JSON_PRETTY_PRINT);
        }
    }
}else
{
    $array1 = null;
    $array->status = 201;
    $array->result = $array1;
    $tracking_list_obj->tracking_list = $array;
    $final_obj->res = $tracking_list_obj;
    echo json_encode($final_obj, JSON_PRETTY_PRINT);
}

