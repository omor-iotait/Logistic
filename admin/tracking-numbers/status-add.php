<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_status_add = "active";
$tracking_menu = "menu-open";
$title = "Tracking Status Add | Admin";
$query = "SELECT * FROM station_prefix";
$result = mysqli_query($con, $query);
if (@$_POST['submit']) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    $query = "INSERT INTO status(name) VALUES('$name')";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "New Tracking Status created successfully";
        header("location:".BASE_URL."admin/tracking-numbers/status-view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Tracking Status Not Inserted!";
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
                                <h3 class="card-title"> Add Tracking Status</h3>
                            </div>
                            <form role="form" action="#" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Tracking Status Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Enter Tracking Status">
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
