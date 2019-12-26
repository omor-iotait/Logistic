<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");


    $query = "select * from customers";
    $result =mysqli_query($con,$query);



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
                        <h1 class="m-0 text-dark">Customer</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="#">Customer List</a></li>
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
                                <h3 class="card-title">Bordered Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
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

<!--                                <button type="button" data-column="#id">Hide/show 1st</button>-->
<!--                                <button type="button" data-column="#name">Hide/show Station</button>-->
<!---->
<!--                                <button type="button" data-column="#email">Hide/show Primary</button>-->
<!--                                <button type="button" data-column="#c_number">Hide/show Secondary</button>-->
<!--                                <button type="button" data-column="#c_id">Hide/show Secondary</button>-->
<!--                                <button type="button" data-column="#c_address">Hide/show Secondary</button>-->
<!--                                <button type="button" data-column="#label">Hide/show Label</button>-->


                                <table class="table table-bordered">
                                    <thead>
                                    <style type="text/css">
                                        .hidden { display: none }
                                    </style>
                                    <tr>
                                        <th style="width: 10px" id="id">#</th>
                                        <th id="name">Customer Name</th>

                                        <th id="email">Email</th>
                                        <th id="c_number">Contact Number</th>
                                        <th id="c_id">Customer ID</th>
                                        <th id="country">Country</th>
                                        <th id="city">City</th>
                                        <th id="state">State</th>
                                        <th id="post_code">Postal Code</th>
                                        <th id="address">Address</th>
                                        <th id="label" style="width: 40px">Label</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id'];?></td>
                                            <td><?php echo $row['username'];?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td><?php echo $row['contact_number'];?></td>
                                            <td><?php echo $row['custom_id'];?></td>
                                            <td><?php echo $row['country'];?></td>
                                            <td><?php echo $row['city'];?></td>
                                            <td><?php echo $row['state'];?></td>
                                            <td><?php echo $row['post_code'];?></td>
                                            <td><?php echo $row['address'];?></td>
                                            <td><span class="badge bg-danger">55%</span></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2019 <a href="#">Amber <Logistic></Logistic></a>.</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include(ROOT_PATH . "admin/includes/scripts_file.php"); ?>



</body>


</html>
