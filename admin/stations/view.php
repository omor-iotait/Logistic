<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");

Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$station_sidebar = "active";
$station_view = "active";
$station_menu = "menu-open";
$title = "Station View | Admin";


$total_pages = $con->query('SELECT * FROM stations')->num_rows;
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Number of results to show on each page.
$num_results_on_page = 1;
if ($stmt = $con->prepare('SELECT * FROM stations ORDER BY id LIMIT ?,?')) {
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
                                    <h3 class="card-title">Station List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <select id="mySelect" class="form-group">
                                        <option>Select</option>
                                        <option data-column="#id">Id</option>
                                        <option data-column="#name">name</option>
                                        <option data-column="#unique_id">unique_id</option>
                                        <option data-column="#p_email">p_email</option>
                                        <option data-column="#s_email">s_email</option>
                                        <option data-column="#label">label</option>
                                    </select>
                                    <!--<button type="button" data-column="#id">Hide/show 1st</button>
                                    <button type="button" data-column="#name">Hide/show Station</button>
                                    <button type="button" data-column="#unique_id">Hide/show Unique</button>
                                    <button type="button" data-column="#p_email">Hide/show Primary</button>
                                    <button type="button" data-column="#s_email">Hide/show Secondary</button>
                                    <button type="button" data-column="#label">Hide/show Label</button>-->
                                    <table class="table table-bordered">
                                        <thead>
                                        <style type="text/css">
                                            .hidden {
                                                display: none
                                            }
                                        </style>
                                        <tr>
                                            <th style="width: 10px" id="id">#</th>
                                            <th id="name">Username</th>
                                            <th id="name">Station Name</th>
                                            <th id="unique_id">Unique ID</th>
                                            <th id="p_email">Primary Email</th>
                                            <th id="s_email">Secondary Email</th>
                                            <th id="contact_number">Contact Number</th>
                                            <th id="country">Country</th>
                                            <th id="state">State</th>
                                            <th id="city">City</th>
                                            <th id="post_code">Post Code</th>
                                            <th id="address">Address</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr id="row<?php echo $row['id'];?>">
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['unique_id']; ?></td>
                                                <td><?php echo $row['primary_email']; ?></td>
                                                <td><?php echo $row['secondary_email']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['country']; ?></td>
                                                <td><?php echo $row['state']; ?></td>
                                                <td><?php echo $row['city']; ?></td>
                                                <td><?php echo $row['post_code']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?php echo $row['id'];?>"><span class="badge bg-info">Edit</span></a>
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
                        url: "delete.php",
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
                        'Station has been deleted.',
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