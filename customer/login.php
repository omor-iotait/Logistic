<!DOCTYPE html>
<html lang="en">

<?php require_once("../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
include(ROOT_PATH . "customer/includes/head.php");

Session::checkCustomerLogin();
if (isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "select * from customers where username='" . $username . "'";
    if (!isset($_COOKIE["member_login"])) {
        $sql .= " AND password = '" . $password . "'";
    }
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        Session::set('customer-login', true);
        while($row = $result->fetch_assoc()) {
            Session::set('customer', $row['name']);
            Session::set('customer_id', $row['id']);
        }

        if (!empty($_POST["remember"])) {
            setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE["member_login"])) {
                setcookie("member_login", "");
            }
        }
        header("Location:index.php");
    } else {
        ?>
        <script>Swal.fire('Error!', '<?php echo "You Have Entered Incorrect Password";?>', 'error');</script>
        <?php
    }
}
?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo BASE_URL?>admin/images/logo.png" height="60px" width="300px">
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in as Customer</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">

                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" value="remember-me" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?>>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include(ROOT_PATH . "customer/includes/scripts_file.php"); ?>

</body>

</html>
