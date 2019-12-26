<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Logistic</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item ">
                    <a href="<?php  echo BASE_URL; ?>station/index.php" class="nav-link <?php echo @$dashboard_sidebar;?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo @$customer_menu;?>">
                    <a href="#" class="nav-link <?php echo @$customer_sidebar;?>">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Customer
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/customers/add.php" class="nav-link <?php echo @$customer_add;?>">
                                <i class="fa fa-circle nav-icon"></i>
                                <p><small>Add Customer</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/customers/view.php" class="nav-link <?php echo @$customer_view;?>">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview <?php echo @$driver_menu;?>">
                    <a href="#" class="nav-link  <?php echo @$driver_sidebar;?>">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Driver
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/drivers/add.php" class="nav-link  <?php echo @$driver_add;?>">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Add Driver</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/drivers/view.php" class="nav-link <?php echo @$driver_view;?>">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Driver List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Tracking Number
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/tracking-numbers/add.php" class="nav-link ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p><small>Add Tracking Number</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>station/tracking-number/view.php" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p><small>Tracking Number List</small></p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>