<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$station_sidebar = "active";
$station_prefix = "active";
$station_menu = "menu-open";
$title = "Station Prefix Set | Admin";
$query = "SELECT * FROM stations";
$result = mysqli_query($con, $query);
if (@$_POST['submit']) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $station_id = mysqli_real_escape_string($con, $_POST['station_id']);


    $query = "INSERT INTO station_prefix(name,station_id) VALUES('$name','$station_id')";
    if ($con->query($query) === TRUE) {
        $_SESSION['success'] = "Station Prefix set successfully";
        header("location:".BASE_URL."admin/stations/view.php");
        exit(0);
    } else {
        $_SESSION['error'] = "Station Prefix Not Set!";
        echo mysqli_error($con);
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
                                <h3 class="card-title"> Station Prefix Set</h3>
                            </div>
                            <form role="form" action="#" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Prefix Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Station Prefix Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="station_id">Station Name</label>
                                        <select id="station_id" name="station_id"
                                                class="form-control form-control-md select2">
                                            <option></option>
                                            <?php
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo @$row['id'];?>"><?php echo @$row['name'];?></option>
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

    $("#station_id").select2({
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
