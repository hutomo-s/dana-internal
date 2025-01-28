<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dana Internal</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/fontawesome-free/css/all.min.css") ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url("assets/adminlte/dist/css/adminlte.min.css") ?>">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <?= session()->get('display_name'); ?> <i class="fas fa-user-circle ml-2"></i> 
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            
                            <div class="dropdown-item">
                                <p>Role: <?= session()->get('role_name'); ?></p>
                                <p>Department: <?= session()->get('department_name'); ?></p>
                            </div>
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="<?= base_url('dashboard/logout'); ?>" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                            </a>
                        </div>
                    </li>
                    
                </ul>
            </nav>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                <img src="<?= base_url("assets/image/logo_dana_blue.svg") ?>" alt="Dana Internal Logo" class="brand-image elevation-3">
                <span class="brand-text font-weight-light">Internal</span>
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('dashboard/users'); ?>" class="nav-link">
                                        <p>All Users</p>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a href="#" class="nav-link">
                                        <p>Roles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a href="#" class="nav-link">
                                        <p>Departments</p>
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
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper pl-3 pb-5">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="d-flex flex-row">
                                    <div class="mr-3"><h1 class="m-0 d-inline-block"><?= $this->renderSection('page_title') ?></h1></div>
                                    <div class=""><?= $this->renderSection('header_content') ?></div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <!-- @content here -->
                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Dompet Digital Terbaik di Indonesia
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2025 <a href="https://www.dana.id/" target="_blank">Dana.id</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?= base_url("assets/adminlte/plugins/jquery/jquery.min.js") ?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url("assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url("assets/adminlte/dist/js/adminlte.min.js") ?>"></script>
        <?= $this->renderSection('script_tags') ?>
    </body>
</html>