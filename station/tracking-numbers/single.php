<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkStationSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$tracking_sidebar = "active";
$tracking_view = "active";
$tracking_menu = "menu-open";
$tracking_number = $_GET['tracking_number'];
$title = $tracking_number." | Station";
$station_id = Session::get('id');
$query_prefix = "select * from station_prefix where station_id='$station_id' LIMIT 1";
$result_prefix = mysqli_query($con, $query_prefix);
$row_prefix = mysqli_fetch_assoc($result_prefix);
$station_prefix_id = $row_prefix['id'];
$query = "SELECT * FROM tracking_numbers WHERE tracking_number='$tracking_number' AND  station_prefix_id=$station_prefix_id ORDER BY id DESC ";
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
                                            <td scope="row"><?php echo $row_prefix['name'].$row['tracking_number']; ?></td>
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
