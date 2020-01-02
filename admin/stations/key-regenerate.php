<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$id = $_GET['id'];
$api_key = bin2hex(random_bytes(32));
$query = "UPDATE stations SET api_key='$api_key'  WHERE id='$id'";
if ($con->query($query) === TRUE) {
    $_SESSION['success'] = "Customer Key regenerated.";
    header("location:" . BASE_URL . "admin/stations/view.php");
    exit(0);
} else {
    $message = "Customer Api Key not Generated.";
    ?>
    <script>
        alert('<?php echo $message?>');
        window.location.replace("<?php echo BASE_URL . 'admin/stations/view.php'?>");
    </script>
    <?php
}
?>