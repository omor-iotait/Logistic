<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>

    </ul>

    <!--<form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-bell"></i>
                <span class="badge badge-warning navbar-badge"><?php echo Session::get('customer');?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="fa fa-users mr-2"></i>
                    <span class="float-right text-muted text-sm">Login as <?php echo Session::get('customer');?></span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo BASE_URL; ?>admin/logout.php" class="dropdown-item">
                    <button class="btn btn-primary">Logout</button>
                </a>

                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>