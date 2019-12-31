<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$station_sidebar = "active";
$station_view = "active";
$station_menu = "menu-open";
$title = "Station Edit | Admin";
$id = $_GET['id'];
$query = "select * from stations where id='$id' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
if (@$_POST['update']) {
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

    $query = "UPDATE stations SET username='$username',password='$password',unique_id='$unique_id',name='$name',primary_email='$primary_email',secondary_email='$secondary_email',contact_number='$contact_number',
country='$country',state='$state',city='$city',post_code='$post_code',address='$address'  WHERE id='$id'";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "Station info updated successfully";
        header("location:".BASE_URL."admin/stations/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Station info Not Inserted!";
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
                                <h3 class="card-title"> Edit Station</h3>
                            </div>
                            <form role="form" action="#" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $row['username'];?>"
                                               placeholder="Enter station's username">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" pattern=".{6,}" class="form-control" name="password"
                                               id="password" placeholder="Password"
                                               title="8 characters minimum">
                                    </div>
                                    <input type="checkbox" onclick="showPassword()">Show Password

                                    <div class="form-group">
                                        <label for="unique_id">Station Unique ID</label>
                                        <input type="text" class="form-control" name="unique_id" id="unique_id" value="<?php echo $row['unique_id'];?>"
                                               placeholder="ID for station">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Station Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name'];?>"
                                               placeholder="Name for station">
                                    </div>

                                    <div class="form-group">
                                        <label for="primary_email">Primary Email address</label>
                                        <input type="email" class="form-control" name="primary_email" id="primary_email" value="<?php echo $row['primary_email'];?>"
                                               placeholder="Enter primary email">
                                    </div>

                                    <div class="form-group">
                                        <label for="secondary_email">Secondary Email address</label>
                                        <input type="email" class="form-control" name="secondary_email" value="<?php echo $row['secondary_email'];?>"
                                               id="secondary_email" placeholder="Enter secondary email">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_number">Contact number</label>
                                        <input type="text" class="form-control" name="contact_number" value="<?php echo $row['contact_number'];?>"
                                               id="contact_number" placeholder="Enter contact number">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" id="country" value="<?php echo $row['country'];?>"
                                                   placeholder="Enter country name">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" id="state" value="<?php echo $row['state'];?>"
                                                   placeholder="Enter state name">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" value="<?php echo $row['city'];?>"
                                                   placeholder="Enter city name">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="post_code">Post code</label>
                                            <input type="text" class="form-control" name="post_code" id="post_code" value="<?php echo $row['post_code'];?>"
                                                   placeholder="Enter post code">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $row['address'];?>"
                                               placeholder="Enter Address">
                                    </div>

                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-primary" name="update" value="Update" id="update"/>
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
   /* var $input = $('input:text'),
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
</body>
</html>
