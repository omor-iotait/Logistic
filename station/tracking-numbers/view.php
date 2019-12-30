<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_view = "active";
$tracking_menu = "menu-open";
$title = "Tracking Number View | Station";
$station_id = Session::get('id');
$query_prefix = "select * from station_prefix where station_id='$station_id' LIMIT 1";
$result_prefix = mysqli_query($con, $query_prefix);
$row_prefix = mysqli_fetch_assoc($result_prefix);
$station_prefix_id = $row_prefix['id'];

$total_pages = $con->query("SELECT * FROM tracking_numbers WHERE station_prefix_id=$station_prefix_id group by tracking_number")->num_rows;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = PAGINATION;
$calc_page = ($page - 1) * $num_results_on_page;
$query = "SELECT * FROM tracking_numbers WHERE station_prefix_id=$station_prefix_id group by tracking_number LIMIT  $calc_page,$num_results_on_page ";
$result = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html lang="en">

<?php
include(ROOT_PATH . "station/includes/head.php"); ?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php
    include(ROOT_PATH . "station/includes/header.php");
    include(ROOT_PATH . "station/includes/sidebar.php");
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
                                    <style type="text/css">
                                        .hidden {
                                            display: none
                                        }
                                    </style>
                                    <style>
                                        .active-cyan-4 input[type=text]:focus:not([readonly]) {
                                            border: 1px solid #4dd0e1;
                                            box-shadow: 0 0 0 1px #4dd0e1;
                                        }

                                        .modal {
                                            display: none; /* Hidden by default */
                                            position: fixed; /* Stay in place */
                                            z-index: 1; /* Sit on top */
                                            padding-top: 100px; /* Location of the box */
                                            margin: auto;
                                            width: 100%; /* Full width */
                                            height: 100%; /* Full height */
                                            overflow: auto; /* Enable scroll if needed */
                                            background-color: rgb(0, 0, 0); /* Fallback color */
                                            background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
                                        }

                                        /* Modal Content (image) */
                                        .modal-content {
                                            margin: auto;
                                            margin-right: 250px;
                                            display: block;
                                            width: 100%;
                                            max-width: 600px;
                                        }


                                        @-webkit-keyframes zoom {
                                            from {
                                                -webkit-transform: scale(0)
                                            }
                                            to {
                                                -webkit-transform: scale(1)
                                            }
                                        }

                                        @keyframes zoom {
                                            from {
                                                transform: scale(0)
                                            }
                                            to {
                                                transform: scale(1)
                                            }
                                        }

                                        /* The Close Button */
                                        .close {
                                            position: absolute;
                                            top: 75px;
                                            right: 45px;
                                            color: #f1f1f1;
                                            font-size: 60px;
                                            font-weight: bold;
                                            transition: 0.3s;
                                        }

                                        .close:hover,
                                        .close:focus {
                                            color: #bbb;
                                            text-decoration: none;
                                            cursor: pointer;
                                        }

                                        .modal-content {
                                            -webkit-animation-name: zoom;
                                            -webkit-animation-duration: 0.6s;
                                            animation-name: zoom;
                                            animation-duration: 0.6s;
                                        }

                                    </style>
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

                                        <?php
                                        /*$track = $row['tracking_number'];
                                        $query1 = "SELECT COUNT(*) as total FROM tracking_numbers WHERE tracking_number='" . $track . "' AND station_prefix_id='" .$station_prefix_id. "' ORDER BY date_stamp desc";
                                        $result1 = mysqli_query($con, $query1);
                                        $data = mysqli_fetch_assoc($result1);
                                        $query2 = "SELECT * FROM tracking_numbers WHERE tracking_number='" . $track . "' AND station_prefix_id=$station_prefix_id ORDER BY date_stamp desc";
                                        $result2 = mysqli_query($con, $query2);
                                        $row1 = mysqli_fetch_assoc($result2);

                                        $flag = 0;
                                        for ($i = 0; $i <= $data['total']; $i++) {

                                            if ($flag == 0) {*/
                                                ?>
                                                <tr id="row<?php echo $row['id']; ?>">
                                                    <td scope="row"><?php echo $row['tracking_number']; ?></td>
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
                                                            <button class='btn btn-primary' id='<?php echo "../../admin/".$row['image_path'] ?>' onclick='imageFunction(this.id)'>View Image</button>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <button class='btn btn-danger' id = '../../admin/upload/default/no-image.png' onclick='imageFunction(this.id)'>No Image</button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                           href="single.php?tracking_number=<?php echo $row['tracking_number']; ?>"><i
                                                                class="fa fa-eye"></i></a>
                                                        <a class="btn btn-info"
                                                           href="edit.php?id=<?php echo $row['id']; ?>"><i
                                                                class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger" onclick="deleteFunction(this.id)"
                                                                id="<?php echo $row['id']; ?>"><i
                                                                class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php /*$flag = 1; $image_id = $row1['image_path'];
                                            }
                                        }*/
                                        ?>

                                        <?php
                                    }
                                    ?>
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
    <?php include(ROOT_PATH . "station/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "station/includes/scripts_file.php"); ?>

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
