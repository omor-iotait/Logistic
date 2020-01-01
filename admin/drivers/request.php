<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$driver_sidebar = "active";
$driver_request = "active";
$driver_menu = "menu-open";
$title = "Driver Request | Admin";
$total_pages = $con->query('SELECT * FROM driver_requests')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = PAGINATION;
$calc_page = ($page - 1) * $num_results_on_page;
$query_request = "SELECT * FROM driver_requests WHERE deliver_status=1 ORDER BY id LIMIT $calc_page,$num_results_on_page";
$result_request = mysqli_query($con, $query_request);
?>

<!DOCTYPE html>
<html lang="en">

<?php
include(ROOT_PATH . "admin/includes/head.php"); ?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php
    include(ROOT_PATH . "admin/includes/header.php");
    include(ROOT_PATH . "admin/includes/sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Driver</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="#">Driver Request List</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Driver Request Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr>
                                        <th id="id">#</th>
                                        <th id="">Driver Name</th>
                                        <th id="">Tracking Number</th>
                                        <th id="">Status</th>
                                        <th id="">Date</th>
                                        <th id="">Sender</th>
                                        <th id="">Receiver</th>
                                        <th id="">Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row_request = mysqli_fetch_assoc($result_request)) {
                                        $tracking_number_id = $row_request['tracking_number_id'];
                                        $query_tracking_number = "select * from drivers where id='$tracking_number_id' LIMIT 1";
                                        $result_tracking_number = mysqli_query($con, $query_tracking_number);
                                        $row_tracking_number = mysqli_fetch_assoc($result_tracking_number);
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['contact_number']; ?></td>
                                            <td><?php echo $row['vehicle_number']; ?></td>
                                            <td><?php echo $row['vehicle_type']; ?></td>
                                            <td><?php echo $row['zone']; ?></td>
                                            <td><?php echo $row['country']; ?></td>
                                            <td><?php echo $row['city']; ?></td>
                                            <td><?php echo $row['state']; ?></td>
                                            <td><?php echo $row['post_code']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>"><span
                                                        class="badge bg-info">Edit</span></a>
                                                <a href="#" id="<?php echo $row['id']; ?>"
                                                   onclick="deleteFunction(this.id)"><span class="badge bg-danger">Delete</span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--Pagination-->
                            <div class="card-footer clearfix">
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                    <ul class="pagination  pull-right">
                                        <?php if ($page > 1): ?>
                                            <li class="prev"><a
                                                    href="view.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                            <li class="start"><a href="view.php?page=1">1</a></li>
                                            <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page - 2 > 0): ?>
                                            <li class="page"><a
                                                href="view.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a>
                                            </li><?php endif; ?>
                                        <?php if ($page - 1 > 0): ?>
                                            <li class="page"><a
                                                href="view.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a>
                                            </li><?php endif; ?>

                                        <li class="currentpage"><a
                                                href="view.php?page=<?php echo $page ?>"><?php echo $page ?></a>
                                        </li>

                                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                            <li class="page"><a
                                                href="view.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a>
                                            </li><?php endif; ?>
                                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                            <li class="page"><a
                                                href="view.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a>
                                            </li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                            <li class="dots">...</li>
                                            <li class="end"><a
                                                    href="view.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                            <li class="next"><a
                                                    href="view.php?page=<?php echo $page + 1 ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php include(ROOT_PATH . "admin/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "admin/includes/scripts_file.php"); ?>

<?php
if (@$_SESSION['success']) {
    ?>
    <script>
        Swal.fire('Success!', '<?php echo $_SESSION['success'];?>', 'success');
    </script>
    <?php
    unset($_SESSION['success']);
}
?>
<script type="text/javascript">
    $(document).on("click", "[data-column]", function () {
        console.log("sdf");
        var button = $(this),
            header = $(button.data("column")),
            table = header.closest("table"),
            index = header.index() + 1, // convert to CSS's 1-based indexing
            selector = "tbody tr td:nth-child(" + index + ")",
            column = table.find(selector).add(header);

        column.toggleClass("hidden");
    });

    $(function () {
        $('select').change(function () {
            var button = $(this).find('option:selected'),
                header = $(button.data("column")),
                table = header.closest("table"),
                index = header.index() + 1,
                selector = "tbody tr td:nth-child(" + index + ")",
                column = table.find(selector).add(header);

            column.toggleClass("hidden")
            /*if (column.toggleClass("hidden")){
                column.toggleClass("")
            }else{
                column.toggleClass("hidden");
            }*/
        }).change();
    });

    function deleteFunction(id) {
        var id = id;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "delete.php",
                    data: {id: id},
                    success: function (data) {
                        if (data == "YES") {
                            $("#row" + id).remove();
                        } else {
                            alert("can't delete the row")
                        }
                    }
                });
                Swal.fire(
                    'Deleted!',
                    'Driver has been deleted.',
                    'success'
                );

            }
        })
    }
</script>
</body>
</html>

