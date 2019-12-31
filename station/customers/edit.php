<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkStationSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$customer_sidebar = "active";
$customer_view = "active";
$customer_menu = "menu-open";
$title = "Customer Update | Admin";
$id = $_GET['id'];
$query = "select * from customers where id='$id' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
if(@$_POST['update']) {

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
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $post_code = mysqli_real_escape_string($con, $_POST['post_code']);
    $address = mysqli_real_escape_string($con, $_POST['address']);


    $query = "UPDATE customers SET username='$username',password='$password',email='$email',name='$name',contact_number='$contact_number',custom_id='$custom_id',company_name='$company_name',
country='$country',state='$state',city='$city',post_code='$post_code',address='$address'  WHERE id='$id'";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "Customer info updated successfully";
        header("location:".BASE_URL."station/customers/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Customer info Not Inserted!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include(ROOT_PATH . "station/includes/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php
    include(ROOT_PATH . "station/includes/header.php");
    include(ROOT_PATH . "station/includes/sidebar.php");
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
                                <h3 class="card-title">Update Customer</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form"  action="" method="post" enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter user's name" value="<?php echo @$row['username'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" pattern=".{6,}" class="form-control" name="password" id="password" placeholder="Password" title="6 characters minimum">
                                    </div>

                                    <input type="checkbox" onclick="showPassword()">Show Password

                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo @$row['email'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter user's name" value="<?php echo @$row['name'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="custom_id">Customer ID</label>
                                        <input type="text" class="form-control" name="custom_id" id="custom_id" placeholder="ID for customer" value="<?php echo @$row['custom_id'];?>">
                                    </div>

                                    <input type="button" class="btn btn-info" onclick="myCustomeid()" value="Generate">

                                    <div class="form-group">
                                        <label for="contact_number">Contact number</label>
                                        <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter user's contact number" value="<?php echo @$row['contact_number'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="company">Company Name</label>
                                        <input type="text" class="form-control" name="company" id="company" placeholder="Enter company's name" value="<?php echo @$row['company_name'];?>">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" id="country" placeholder="country" value="<?php echo @$row['country'];?>">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" id="state" placeholder="state" value="<?php echo @$row['state'];?>">
                                        </div>



                                        <div class="form-group col-md-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="city" value="<?php echo @$row['city'];?>">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="post_code">Post code</label>
                                            <input type="text" class="form-control" name="post_code" id="post_code" placeholder="postal code" value="<?php echo @$row['post_code'];?>">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="address" value="<?php echo @$row['address'];?>">
                                    </div>

                                    <div class="card-footer">
                                        <input type="submit" name="update" id="update" class="btn btn-primary" value="Update">
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
</body>
<script type="text/javascript">
    /*var $input = $('input:text'),
        $register = $('#update');

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

</html>



