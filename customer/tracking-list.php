<?php
require_once("../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkCustomerSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
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
    <?php include(ROOT_PATH . "customer/includes/footer.php"); ?>
</div>
<?php include(ROOT_PATH . "customer/includes/scripts_file.php"); ?>
</body>
</html>
