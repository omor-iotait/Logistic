<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkStationSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_add = "active";
$tracking_menu = "menu-open";
$title = "Tracking Number Add | Admin";
$id = $_GET['id'];
$station_id = Session::get('id');
$query = "select * from tracking_numbers where id='$id' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$query_status = "SELECT * FROM status";
$result_status = mysqli_query($con, $query_status);
$query_customer = "SELECT * FROM customers WHERE created_by='$station_id'";
$result_customer = mysqli_query($con, $query_customer);
$query_receiver = "SELECT * FROM customers WHERE created_by='$station_id'";
$result_receiver = mysqli_query($con, $query_receiver);
if (@$_POST['submit']) {
    $tracking_number = mysqli_real_escape_string($con, $_POST['tracking_number']);
    $date_stamp = mysqli_real_escape_string($con, $_POST['date_stamp']);
    $date = strtotime($date_stamp);
    $status_id = mysqli_real_escape_string($con, $_POST['status_id']);
    $remark = mysqli_real_escape_string($con, $_POST['remark']);
    $sender_id = mysqli_real_escape_string($con, $_POST['sender_id']);
    $receiver_id = mysqli_real_escape_string($con, $_POST['receiver_id']);

    if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])){
        $query1 = "UPDATE tracking_numbers SET tracking_number = '$tracking_number',date_stamp = '$date',status_id = '$status_id',remark = '$remark',sender_id='$sender_id',receiver_id='$receiver_id' WHERE id='$id'";
        if ($con->query($query1) === TRUE) {
            $_SESSION['success'] = "Selected Tracking info updated successfully";
            header("location:".BASE_URL."station/tracking-numbers/view.php");
            exit(0);
        } else {
            $_SESSION['error'] = "Tracking info Not updated!";
        }
    }
    else{

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];
        $data = getimagesize($file_temp);
        $w = $data[0]/2;
        $h = $data[1]/2;
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;


        if (in_array($file_ext, $permited) === false || empty($uploaded_image)) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
            $uploadedImage = imagecreatefromjpeg($file_temp);
            $oldw = imagesx($uploadedImage);
            $oldh = imagesy($uploadedImage);
            $temp = imagecreatetruecolor($w, $h);
            imagecopyresampled($temp, $uploadedImage, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
            imagejpeg($temp, "../../admin/upload/" . $unique_image);
        }

        $query2 = "UPDATE tracking_numbers SET tracking_number = '$tracking_number',date_stamp = '$date',status_id = '$status_id',remark = '$remark',sender_id='$sender_id',receiver_id='$receiver_id',image_path='$uploaded_image' WHERE id='$id'";
        if ($con->query($query2) === TRUE) {
            $_SESSION['success'] = "Selected Tracking info updated successfully";
            header("location:".BASE_URL."station/tracking-numbers/view.php");
            exit(0);
        } else {
            $message = "Tracking Info not Updated.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include(ROOT_PATH . "station/includes/head.php");
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php
    include(ROOT_PATH . "station/includes/header.php");
    include(ROOT_PATH . "station/includes/sidebar.php");
    ?>
    <div class="content-wrapper">
        <br>
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"> Edit Tracking Number</h3>
                            </div>
                            <form role="form" action="" method="post" enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="tracking_number">Tracking Number</label>
                                        <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="<?php echo $row['tracking_number']?>"
                                               placeholder="Enter Tracking Number">
                                    </div>

                                    <div class="form-group">
                                        <label for="status_id">Status</label>
                                        <select id="status_id" name="status_id"
                                                class="form-control form-control-md">
                                            <?php
                                            while($status = $result_status->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$status['id'];?>" <?php echo ($row['status_id'] == $status['id'] ? "selected": "")?>><?php echo @$status['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="date_stamp">Date</label>
                                        <input type="text" class="form-control datepicker" id="date_stamp" placeholder="Enter Date" name= "date_stamp" value="<?php echo date('d-m-Y',$row['date_stamp'])?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Select Image</label>
                                        <img src="<?php echo "../../admin/".$row['image_path']?>" height="50" width="70">
                                        <input type="file" name="image" id="image" class="image">
                                    </div>

                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <textarea class="form-control" id="remark" rows="3" name="remark" required><?php echo $row['remark'];?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="sender_id">Sender</label>

                                        <select id="sender_id" name="sender_id"
                                                class="form-control form-control-md">
                                            <?php
                                            while($customer = $result_customer->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$customer['id'];?>" <?php echo ($row['sender_id'] == $customer['id'] ? "selected": "")?>><?php echo @$customer['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="receiver_id">Receiver</label>
                                        <select id="receiver_id" name="receiver_id"
                                                class="form-control form-control-md">
                                            <?php
                                            while($receiver = $result_receiver->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$receiver['id'];?>" <?php echo ($row['receiver_id'] == $receiver['id'] ? "selected": "")?>><?php echo @$receiver['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Update"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php include(ROOT_PATH . "station/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "station/includes/scripts_file.php"); ?>
<script type="text/javascript">


    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    });


</script>
</body>
</html>
