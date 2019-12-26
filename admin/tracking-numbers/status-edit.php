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
$id = $_GET['id'];
$query = "select * from status where id='$id' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
if (@$_POST['submit']) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    $query = "UPDATE status SET name='$name'";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "Tracking Status updated successfully";
        header("location:".BASE_URL."admin/tracking-numbers/status-view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Tracking Status Not updated!";
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
                                        <label for="name">Tracking Status Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo @$row['name'];?>">
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
    <?php include(ROOT_PATH . "admin/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "admin/includes/scripts_file.php"); ?>

</body>
</html>
