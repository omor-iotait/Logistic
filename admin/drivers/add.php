<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$driver_sidebar = "active";
$driver_add = "active";
$driver_menu = "menu-open";
$title = "Driver Add | Admin";
if (@$_POST['submit']) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = md5($password);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $vehicle_number = mysqli_real_escape_string($con, $_POST['vehicle_number']);
    $vehicle_type = mysqli_real_escape_string($con, $_POST['vehicle_type']);
    $zone = mysqli_real_escape_string($con, $_POST['zone']);

    $country = mysqli_real_escape_string($con, $_POST['country']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $post_code = mysqli_real_escape_string($con, $_POST['post_code']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    if ($_FILES['image']['tmp_name'] == FALSE) {
        echo "Please select an image";
    } else {
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "../upload/" . $unique_image;


        if (in_array($file_ext, $permited) === false || empty($uploaded_image)) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
        }
    }

    $query = "INSERT INTO `drivers`(`username`,`password`,`email`,`name`,`contact_number`,`vehicle_number`,`vehicle_type`,`zone`,`image_path`,`country`,`state`,`city`,`post_code`,`address`)
VALUES('$username','$password','$email','$name','$contact_number','$vehicle_number','$vehicle_type','$zone','$uploaded_image','$country','$state','$city','$post_code','$address')";

    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "New Driver info created successfully";
        header("location:" . BASE_URL . "admin/drivers/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Driver info Not Inserted!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include(ROOT_PATH . "admin/includes/head.php"); ?>

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
                                <h3 class="card-title">Add Driver</h3>
                            </div>
                            <form role="form" action="" method="post" enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username"
                                               placeholder="Enter driver's name">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" pattern=".{6,}" class="form-control" name="password"
                                               id="password" placeholder="Password" required
                                               title="6 characters minimum">
                                    </div>

                                    <input type="checkbox" onclick="showPassword()">Show Password

                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                               placeholder="Enter driver's email">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Enter driver's name">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_number">Contact number</label>
                                        <input type="text" class="form-control" name="contact_number"
                                               id="contact_number" placeholder="Enter drivers contact number">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">

                                            <label for="vehicle_number">Vehicle number</label>
                                            <input type="text" class="form-control" name="vehicle_number"
                                                   id="vehicle_number" placeholder="Enter vehicle's number">
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="vehicle_type">Vehicle Type</label>
                                            <select id="vehicle_type" name="vehicle_type"
                                                    class="form-control form-control-md">
                                                <option>Select Vehicle Type</option>
                                                <option>Lorry/Truck</option>
                                                <option>Motorcycle</option>

                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="image">Input Driver's image</label>
                                        <input type="file" name="image" class="image" id="image">
                                    </div>

                                    <div class="form-group">

                                        <label for="zone">Input Zone</label>
                                        <input type="text" class="form-control" name="zone"
                                               id="zone" placeholder="Enter zone name">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" id="country"
                                                   placeholder="country">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" id="state"
                                                   placeholder="state">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city"
                                                   placeholder="city">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="post_code">Post code</label>
                                            <input type="text" class="form-control" name="post_code" id="post_code"
                                                   placeholder="postal code">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" id="address"
                                               placeholder="address">
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
</script>
</body>
</html>

