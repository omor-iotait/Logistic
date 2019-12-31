<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$customer_sidebar = "active";
$customer_add = "active";
$customer_menu = "menu-open";
$title = "Customer Add | Admin";
if(@$_POST['submit']) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = md5($password);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $custom_id = mysqli_real_escape_string($con, $_POST['custom_id']);
    $company_name = mysqli_real_escape_string($con, $_POST['company']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    if(Session::get('admin')){
        $creator_type = 1;
    }
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $post_code = mysqli_real_escape_string($con, $_POST['post_code']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    $query = "INSERT INTO `customers`(`username`,`password`,`email`,`name`,`contact_number`,`custom_id`,`company_name`,`country`,`state`,`city`,`post_code`,`address`,`creator_type`) 

VALUES('$username','$password','$email','$name','$contact_number','$custom_id','$company_name','$country','$state','$city','$post_code','$address','1')";


    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "New customer info created successfully";
        header("location:".BASE_URL."admin/customers/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "customer info Not Inserted!";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include(ROOT_PATH . "admin/includes/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php
    include(ROOT_PATH . "admin/includes/header.php");
    include(ROOT_PATH . "admin/includes/sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Customer</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form"  action="" method="post" enctype="multipart/form-data" >
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter user's name">
                                    </div>


                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" pattern=".{6,}" class="form-control" name="password" id="password" placeholder="Password"    required title="6 characters minimum">
                                    </div>

                                    <input type="checkbox" onclick="showPassword()">Show Password


                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter user's name">
                                    </div>

                                    <div class="form-group">
                                        <label for="custom_id">Customer ID</label>
                                        <input type="text" class="form-control" name="custom_id" id="custom_id" onkeyup="checkAvailability()" placeholder="ID for customer"><span id="user-availability-status"></span>
                                    </div>


                                    <input type="button" class="btn btn-info" onclick="myCustomeid()" value="Generate">


                                    <div class="form-group">
                                        <label for="contact_number">Contact number</label>
                                        <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter user's contact number">
                                    </div>

                                    <div class="form-group">
                                        <label for="company">Company Name</label>
                                        <input type="text" class="form-control" name="company" id="company" placeholder="Enter company's name">
                                    </div>

                                    <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" name="country" id="country" placeholder="country">
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" name="state" id="state" placeholder="state">
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="city">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="post_code">Post code</label>
                                        <input type="text" class="form-control" name="post_code" id="post_code" placeholder="postal code">
                                    </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="address">
                                    </div>

                                <div class="card-footer">
                                    <input type="submit" name="submit" id="submit" class="btn btn-primary">
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


<script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check.php",
            data:'custom_id='+$("#custom_id").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
</script>




<script type="text/javascript">
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



