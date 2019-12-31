<?php
require_once("../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkCustomerSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$dashboard_sidebar = "active";
$title = "Tracking Number View | Customer";
$receiver_id = Session::get('customer_id');

$total_pages = $con->query("SELECT * FROM tracking_numbers WHERE receiver_id=$receiver_id group by tracking_number")->num_rows;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = PAGINATION;
$calc_page = ($page - 1) * $num_results_on_page;
$query = "SELECT * FROM tracking_numbers WHERE receiver_id=$receiver_id group by tracking_number LIMIT  $calc_page,$num_results_on_page ";
$result = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html lang="en">

<?php
include(ROOT_PATH . "customer/includes/head.php"); ?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php
    include(ROOT_PATH . "customer/includes/header.php");
    include(ROOT_PATH . "customer/includes/sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tracking Number List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table class="table table-bordered" id="result" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Tracking Number</th>
                                        <th>Status</th>
                                        <th>Date Stamp</th>
                                        <th>Remark</th>
                                        <th>Image</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr id="row<?php echo $row['id']; ?>">
                                            <td scope="row">
                                                <?php
                                                $prefix_id = $row['station_prefix_id'];
                                                $query_prefix = "select * from station_prefix where id='$prefix_id' LIMIT 1";
                                                $result_prefix = mysqli_query($con, $query_prefix);
                                                $row_prefix = mysqli_fetch_assoc($result_prefix);
                                                echo $row_prefix['name'].$row['tracking_number']; ?></td>
                                            <td>
                                                <?php
                                                $status_id = $row['status_id'];
                                                $query_sta = "select * from status where id='$status_id' LIMIT 1";
                                                $result_sta = mysqli_query($con, $query_sta);
                                                $row_sta = mysqli_fetch_assoc($result_sta);
                                                echo $row_sta['name'];
                                                ?>
                                            </td>
                                            <td><?php echo date('d/m/Y', $row['date_stamp']);?></td>
                                            <td><?php echo $row['remark'] ?></td>
                                            <td>
                                                <?php
                                                if (isset($row['image_path']) && !empty($row['image_path'])) {
                                                    ?>
                                                    <button class='btn btn-primary' id='<?php echo "../admin/".$row['image_path'] ?>' onclick='imageFunction(this.id)'>View Image</button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class='btn btn-danger' id = '../admin/upload/default/no-image.png' onclick='imageFunction(this.id)'>No Image</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="single.php?tracking_number=<?php echo $row['tracking_number']; ?>"><i
                                                        class="fa fa-eye"></i></a>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--Pagination-->
                            <div class="card-footer clearfix">
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                    <ul class="pagination  pull-right">
                                        <?php if ($page > 1): ?>
                                            <li class="prev"><a
                                                    href="index.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                            <li class="start"><a href="index.php?page=1">1</a></li>
                                            <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page - 2 > 0): ?>
                                            <li class="page"><a
                                                href="index.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a>
                                            </li><?php endif; ?>
                                        <?php if ($page - 1 > 0): ?>
                                            <li class="page"><a
                                                href="index.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a>
                                            </li><?php endif; ?>

                                        <li class="currentpage"><a
                                                href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a>
                                        </li>

                                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                            <li class="page"><a
                                                href="index.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a>
                                            </li><?php endif; ?>
                                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                            <li class="page"><a
                                                href="index.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a>
                                            </li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                            <li class="dots">...</li>
                                            <li class="end"><a
                                                    href="index.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                            <li class="next"><a
                                                    href="index.php?page=<?php echo $page + 1 ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div id="myModal" class="modal">
                                <span class="close">&times;</span>
                                <img class="modal-content" id="img01">
                                <div id="caption"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php include(ROOT_PATH . "customer/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "customer/includes/scripts_file.php"); ?>
<?php
if (@$_SESSION['success'])
{
    ?>
    <script>
        Swal.fire('Success!', '<?php echo $_SESSION['success'];?>', 'success');
    </script>
    <?php
    unset($_SESSION['success']);
}
?>
<script type="text/javascript">
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");

    function imageFunction(id) {

        modal.style.display = "block";
        modalImg.src = id;
    }

    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
        modal.style.display = "none";
    }
</script>
</body>
</html>
