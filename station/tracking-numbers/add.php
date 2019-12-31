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
$title = "Tracking Number Add | Station";
$station_id = Session::get('id');
$query_status = "SELECT * FROM status";
$result_status = mysqli_query($con, $query_status);
$query_prefix = "select * from station_prefix where station_id='$station_id' LIMIT 1";
$result_prefix = mysqli_query($con, $query_prefix);
$row_prefix = mysqli_fetch_assoc($result_prefix);
$station_prefix_id = $row_prefix['id'];
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

    if($_FILES['image']['tmp_name'] == FALSE){
        echo "Please select an image";
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
    }

    $query = "INSERT INTO tracking_numbers(tracking_number,station_prefix_id,status_id,date_stamp,image_path,remark,sender_id,receiver_id) VALUES('$tracking_number','$station_prefix_id','$status_id','$date','$uploaded_image','$remark','$sender_id','$receiver_id')";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "New tracking info created successfully";
        header("location:".BASE_URL."station/tracking-numbers/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Tracking info Not Inserted!";

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
                                <h3 class="card-title"> Add Tracking Number</h3>
                            </div>
                            <form role="form" action="" method="post" enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="tracking_number">Tracking Number</label>
                                        <input type="text" class="form-control" name="tracking_number" id="tracking_number"
                                               placeholder="Enter Tracking Number">
                                    </div>

                                    <div class="form-group">
                                        <label for="status_id">Status</label>
                                        <select id="status_id" name="status_id"
                                                class="form-control form-control-md">
                                            <option>Status</option>
                                            <?php
                                            while($status = $result_status->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$status['id'];?>"><?php echo @$status['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="date_stamp">Date</label>
                                        <input type="text" class="form-control datepicker" id="date_stamp" placeholder="Enter Date" name= "date_stamp" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Select Image</label>
                                        <input type="file" name="image" id="image" class="image">
                                    </div>

                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <textarea class="form-control" id="remark" rows="3" name="remark" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="sender_id">Sender</label>
                                        <select id="sender_id" name="sender_id"
                                                class="form-control form-control-md">
                                            <option selected disabled>Sender</option>
                                            <?php

                                            while($customer = $result_customer->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$customer['id'];?>"><?php echo @$customer['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="receiver_id">Receiver</label>
                                        <select id="receiver_id" name="receiver_id"
                                                class="form-control form-control-md">
                                            <option selected disabled>Receiver</option>
                                            <?php
                                            while($receiver = $result_receiver->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$receiver['id'];?>"><?php echo @$receiver['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-primary" id="submit" name="submit"/>
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


    /*var $input = $('input:text'),
        $register = $('#submit');

    $register.attr('disabled', true);
    $input.keyup(function() {
        var trigger = false;
        $input.each(function() {
            if (!$(this).val()) {
                trigger = true;
            }
        });
        trigger ? $register.attr('disabled', true) : $register.removeAttr('disabled');
    });*/
</script>
</body>
</html>
