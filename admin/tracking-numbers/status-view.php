<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_status_view = "active";
$tracking_menu = "menu-open";
$title = "Tracking Status View | Admin";


$total_pages = $con->query('SELECT * FROM status')->num_rows;
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Number of results to show on each page.
$num_results_on_page = 1;
if ($stmt = $con->prepare('SELECT * FROM status ORDER BY id LIMIT ?,?')) {
// Calculate the page to get the results we need from our table.
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
// Get the results...
    $result = $stmt->get_result();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <?php include(ROOT_PATH . "admin/includes/head.php"); ?>
    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tracking Status List</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <style type="text/css">
                                            .hidden {
                                                display: none
                                            }
                                        </style>
                                        <tr>
                                            <th style="width: 10px" id="id">#</th>
                                            <th id="name">Status Name</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr id="row<?php echo $row['id'];?>">
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <a href="status-edit.php?id=<?php echo $row['id'];?>"><span class="badge bg-info">Edit</span></a>
                                                    <a href="#" id="<?php echo $row['id'];?>" onclick="deleteFunction(this.id)"><span class="badge bg-danger">Delete</span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!--Pagination-->
                                <div class="card-footer clearfix">
                                    <style type="text/css">
                                        .pagination {
                                            list-style-type: none;
                                            padding: 5px 5px;
                                            display: inline-flex;
                                            justify-content: space-between;
                                            box-sizing: border-box;
                                        }
                                        .pagination li {
                                            box-sizing: border-box;
                                            padding-right: 10px;
                                        }
                                        .pagination li a {
                                            box-sizing: border-box;
                                            background-color: #e2e6e6;
                                            padding: 12px;
                                            text-decoration: none;
                                            font-size: 12px;
                                            font-weight: bold;
                                            color: #616872;
                                            border-radius: 4px;
                                        }
                                        .pagination li a:hover {
                                            background-color: #d4dada;
                                        }
                                        .pagination .next a, .pagination .prev a {
                                            text-transform: uppercase;
                                            font-size: 12px;
                                        }
                                        .pagination .currentpage a {
                                            background-color: #518acb;
                                            color: #fff;
                                        }
                                        .pagination .currentpage a:hover {
                                            background-color: #518acb;
                                        }
                                    </style>
                                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                        <ul class="pagination  pull-right">
                                            <?php if ($page > 1): ?>
                                                <li class="prev"><a
                                                        href="status-view.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                            <?php endif; ?>

                                            <?php if ($page > 3): ?>
                                                <li class="start"><a href="status-view.php?page=1">1</a></li>
                                                <li class="dots">...</li>
                                            <?php endif; ?>

                                            <?php if ($page - 2 > 0): ?>
                                                <li class="page"><a
                                                    href="status-view.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a>
                                                </li><?php endif; ?>
                                            <?php if ($page - 1 > 0): ?>
                                                <li class="page"><a
                                                    href="status-view.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a>
                                                </li><?php endif; ?>

                                            <li class="currentpage"><a
                                                    href="status-view.php?page=<?php echo $page ?>"><?php echo $page ?></a>
                                            </li>

                                            <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                                <li class="page"><a
                                                    href="status-view.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a>
                                                </li><?php endif; ?>
                                            <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                                                <li class="page"><a
                                                    href="status-view.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a>
                                                </li><?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                <li class="dots">...</li>
                                                <li class="end"><a
                                                        href="status-view.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                <li class="next"><a
                                                        href="status-view.php?page=<?php echo $page + 1 ?>">Next</a></li>
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
    <!-- ./wrapper -->

    <?php include(ROOT_PATH . "admin/includes/scripts_file.php"); ?>
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

        function deleteFunction(id){
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
                        url: "status-delete.php",
                        data: {id:id},
                        success: function (data) {
                            if(data=="YES"){
                                $("#row"+id).remove();
                            }else{
                                alert("can't delete the row")
                            }
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Status has been deleted.',
                        'success'
                    );

                }
            })
        }
    </script>
    </body>
    </html>
    <?php
    $stmt->close();
}
?>