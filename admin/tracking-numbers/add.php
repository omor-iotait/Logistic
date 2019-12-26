<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_add = "active";
$tracking_menu = "menu-open";
$title = "Tracking Number Add | Admin";
$query = "SELECT * FROM station_prefix";
$result = mysqli_query($con, $query);
$query_status = "SELECT * FROM status";
$result_status = mysqli_query($con, $query_status);
$query_customer = "SELECT * FROM customers";
$result_customer = mysqli_query($con, $query_customer);
if (@$_POST['submit']) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = md5($password);
    $unique_id = mysqli_real_escape_string($con, $_POST['unique_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $primary_email = mysqli_real_escape_string($con, $_POST['primary_email']);
    $secondary_email = mysqli_real_escape_string($con, $_POST['secondary_email']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $post_code = mysqli_real_escape_string($con, $_POST['post_code']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    $query = "INSERT INTO stations(username,password,unique_id,name,primary_email,secondary_email,contact_number,country,state,city,post_code,address) 
VALUES('$username','$password','$unique_id','$name','$primary_email','$secondary_email','$contact_number','$country','$state','$city','$post_code','$address')";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "New Station info created successfully";
        header("location:".BASE_URL."admin/stations/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Station info Not Inserted!";
        echo mysqli_error();

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include(ROOT_PATH . "admin/includes/head.php");
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php
    include(ROOT_PATH . "admin/includes/header.php");
    include(ROOT_PATH . "admin/includes/sidebar.php");
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
                            <form role="form" action="#" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="tracking_number">Tracking Number</label>
                                        <input type="text" class="form-control" name="tracking_number" id="tracking_number"
                                               placeholder="Enter Tracking Number">
                                    </div>

                                    <div class="form-group">
                                        <label for="station_prefix_id">Station Prefix</label>
                                        <select id="station_prefix_id" name="station_prefix_id"
                                                class="form-control form-control-md select2">
                                            <option>Station Prefix</option>
                                            <?php
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$row['id'];?>"><?php echo @$row['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="status_id">Status</label>
                                        <select id="status_id" name="status_id"
                                                class="form-control form-control-md select2">
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
                                                class="form-control form-control-md select2">
                                            <option>Status</option>
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
                                                class="form-control form-control-md select2">
                                            <option>Status</option>
                                            <?php
                                            while($customers = $result_customer->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$customers['id'];?>"><?php echo @$customers['name'];?></option>
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
    <?php include(ROOT_PATH . "admin/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "admin/includes/scripts_file.php"); ?>
<script type="text/javascript">


    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    });

    $("#station_prefix_id").select2({
        width: "resolve"
    });

    $("#status_id").select2({
        width: "resolve"
    });

    var $input = $('input:text'),
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
    });
</script>
</body>
</html>
