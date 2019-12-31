<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkAdminSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_view = "active";
$tracking_menu = "menu-open";
$title = "Tracking Number View | Admin";

$total_pages = $con->query('SELECT * FROM tracking_numbers group by tracking_number')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = PAGINATION;
$calc_page = ($page - 1) * $num_results_on_page;
$query = "SELECT * FROM tracking_numbers group by tracking_number LIMIT $calc_page,$num_results_on_page";
$result = mysqli_query($con, $query);

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
                            <div class="card-body container-fluid">
                                <select id="mySelect">
                                    <option>Select</option>
                                    <option data-column="#id" value="gh">ID</option>
                                    <option data-column="#name">name</option>

                                    <option data-column="#email">Email</option>
                                    <option data-column="#c_number">Contact Number</option>
                                    <option data-column="#c_id">Customer ID</option>
                                    <option data-column="#country">Country</option>
                                    <option data-column="#city">City</option>
                                    <option data-column="#state">State</option>
                                    <option data-column="#post_code">Postal Code</option>
                                    <option data-column="#address">Address</option>

                                    <option data-column="#label">label</option>
                                </select>

                                <table class="table table-bordered layout-fixed" id="result" width="100%" cellspacing="0">
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
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tbody>
                                        <?php
                                        $track = $row['tracking_number'];
                                        $query1 = "SELECT COUNT(*) as total FROM tracking_numbers WHERE tracking_number='" . $track . "' ORDER BY date_stamp desc";
                                        $result1 = mysqli_query($con, $query1);
                                        $data = mysqli_fetch_assoc($result1);
                                        $query2 = "SELECT * FROM tracking_numbers WHERE tracking_number='" . $track . "' ORDER BY date_stamp desc";
                                        $result2 = mysqli_query($con, $query2);
                                        $row1 = mysqli_fetch_assoc($result2);

                                        $flag = 0;
                                        for ($i = 0; $i <= $data['total']; $i++) {

                                            if ($flag == 0) {
                                                ?>
                                                <tr id="row<?php echo $row1['id']; ?>">
                                                    <td scope="row">
                                                        <?php
                                                        $prefix_id = $row['station_prefix_id'];
                                                        $query_prefix = "select * from station_prefix where id='$prefix_id' LIMIT 1";
                                                        $result_prefix = mysqli_query($con, $query_prefix);
                                                        $row_prefix = mysqli_fetch_assoc($result_prefix);
                                                        echo $row_prefix['name'].$row['tracking_number']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $status_id = $row1['status_id'];
                                                        $query_sta = "select * from status where id='$status_id' LIMIT 1";
                                                        $result_sta = mysqli_query($con, $query_sta);
                                                        $row_sta = mysqli_fetch_assoc($result_sta);
                                                        echo $row_sta['name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d/m/Y', $row1['date_stamp']);?></td>
                                                    <td><?php echo $row1['remark'] ?></td>
                                                    <td>
                                                        <?php
                                                        if (isset($row1['image_path']) && !empty($row1['image_path'])) {
                                                            ?>
                                                            <button class='btn btn-primary' id='<?php echo "../".$row1['image_path'] ?>' onclick='imageFunction(this.id)'>View Image</button>
                                                        <?php
                                                        } else {
                                                            ?>
                                                            <button class='btn btn-danger' id = '../upload/default/no-image.png' onclick='imageFunction(this.id)'>No Image</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm"
                                                           href="single.php?tracking_number=<?php echo $row1['tracking_number']; ?>"><i
                                                                    class="fa fa-eye"></i></a>
                                                        <a class="btn btn-primary btn-sm"
                                                           href="pdf.php?tracking_number=<?php echo $row1['tracking_number']; ?>"><i
                                                                    class="fa fa-file"></i></a>
                                                        <a class="btn btn-info btn-sm"
                                                           href="edit.php?id=<?php echo $row1['id']; ?>"><i
                                                                    class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="deleteFunction(this.id)"
                                                                id="<?php echo $row1['id']; ?>"><i
                                                                    class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $flag = 1; $image_id = $row1['image_path'];
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
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
                    'Selected Tracking Number has been deleted.',
                    'success'
                );

            }
        })
    }


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
