<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo BASE_URL?>customer" class="brand-link">
        <span class="brand-text font-weight-light">Logistic</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="<?php  echo BASE_URL; ?>customer/index.php" class="nav-link <?php echo @$dashboard_sidebar;?>">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php  echo BASE_URL; ?>customer/my-account.php" class="nav-link <?php echo @$customer_sidebar;?>">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            My Account
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>