<?php
require_once("../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkStationSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$station_sidebar = "active";
$title = "Station Prefix Set | Station";
$station_id = Session::get('id');
$query = "select * from station_prefix where station_id='$station_id' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
if (@$_POST['submit']) {

    $name = mysqli_real_escape_string($con, $_POST['name']);

    $query = "UPDATE station_prefix SET name='$name' WHERE station_id='$station_id'";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "Station Prefix set successfully";
        header("location:".BASE_URL."station/index.php");
        exit(0);
    } else {
        $message = "Station Prefix Not Set!";
        echo "<script type='text/javascript'>alert('$message');</script>";
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
                                <h3 class="card-title"> Station Prefix Set</h3>
                            </div>
                            <form role="form" action="#" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Prefix Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name']?>"
                                               placeholder="Station Prefix Name">
                                    </div>

                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save"/>
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
