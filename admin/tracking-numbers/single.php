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
$tracking_number = $_GET['tracking_number'];
$title = $tracking_number." | Admin";
$query = "SELECT * FROM tracking_numbers WHERE tracking_number='$tracking_number' ORDER BY id DESC ";
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
                                            $query_status = "SELECT * FROM status WHERE id='$status_id' LIMIT 1";
                                            $result_status = mysqli_query($con, $query_status);
                                            $row_status = mysqli_fetch_assoc($result_status);
                                            echo $row_status['name'];
                                            ?>
                                        </td>
                                        <td><?php echo date('d/m/Y', $row['date_stamp']); ?></td>
                                        <td><?php echo $row['remark'] ?></td>
                                        <td>
                                            <?php
                                            if (isset($row['image_path']) && !empty($row['image_path'])) {
                                                ?>
                                                <button class='btn btn-primary' id='<?php echo "../".$row['image_path'] ?>' onclick='imageFunction(this.id)'>View Image</button>
                                                <?php
                                            } else {
                                                ?>
                                                <button class='btn btn-danger' id = '../upload/default/no-image.png' onclick='imageFunction(this.id)'>No Image</button>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info"
                                               href="edit.php?id=<?php echo $row['id']; ?>"><i
                                                    class="fa fa-edit"></i></a>
                                            <button class="btn btn-danger" onclick="deleteFunction(this.id)"
                                                    id="<?php echo $row['id']; ?>"><i
                                                    class="fa fa-trash"></i>
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
