<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL?>admin" class="brand-link">
        <span class="brand-text font-weight-light"><img src="<?php echo BASE_URL?>admin/images/logo.png" height="45px" width="200px"></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item ">
                    <a href="<?php  echo BASE_URL; ?>admin/index.php" class="nav-link <?php echo @$dashboard_sidebar;?>">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo @$customer_menu;?>">
                    <a href="#" class="nav-link <?php echo @$customer_sidebar;?>">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Customer
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/customers/add.php" class="nav-link <?php echo @$customer_add;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p><small>Add Customer</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/customers/view.php" class="nav-link <?php echo @$customer_view;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo @$station_menu;?>">
                    <a href="#" class="nav-link <?php echo @$station_sidebar;?>">
                        <i class="nav-icon fa fa-industry"></i>
                        <p>
                            Station
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/stations/add.php" class="nav-link <?php echo @$station_add;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Add Station</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/stations/view.php" class="nav-link <?php echo @$station_view;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Station List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/stations/prefix.php" class="nav-link <?php echo @$station_prefix;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Prefix Set</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?php echo @$driver_menu;?>">
                    <a href="#" class="nav-link  <?php echo @$driver_sidebar;?>">
                        <i class="nav-icon fa fa-car"></i>
                        <p>
                            Driver
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/drivers/add.php" class="nav-link <?php echo @$driver_add;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Add Driver</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/drivers/view.php" class="nav-link <?php echo @$driver_view;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Driver List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/drivers/request.php" class="nav-link <?php echo @$driver_request;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Delivery Request</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?php echo @$tracking_menu;?>">
                    <a href="#" class="nav-link <?php echo @$tracking_sidebar;?>">
                        <i class="nav-icon fa fa-barcode"></i>
                        <p>
                            Tracking Number
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/tracking-numbers/add.php" class="nav-link <?php echo @$tracking_add;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p><small>Add Tracking Number</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/tracking-numbers/view.php" class="nav-link <?php echo @$tracking_view;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p><small>Tracking Number List</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/tracking-numbers/status-add.php" class="nav-link <?php echo @$tracking_status_add;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p><small>Tracking Status Add</small></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php  echo BASE_URL; ?>admin/tracking-numbers/status-view.php" class="nav-link <?php echo @$tracking_status_view;?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p><small>Tracking Status List</small></p>
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