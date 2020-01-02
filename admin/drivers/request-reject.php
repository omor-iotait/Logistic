<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}

$id = $_GET['id'];
$query_request_update = "UPDATE driver_requests SET deliver_status=3 WHERE id='$id'";
if ($con->query($query_request_update) == TRUE) {
    $_SESSION['success'] = "Requested Info rejected.";
    header("location:" . BASE_URL . "admin/drivers/request.php");
    exit(0);
} else {?>
    <script>
        alert('Error! Requested Info rejected.');
        window.location.replace("<?php echo BASE_URL . 'admin/drivers/request.php'?>");
    </script>
    <?php
}
