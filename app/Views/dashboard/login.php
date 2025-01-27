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
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline">
                <div class="card-header text-center">
                <img src="<?= base_url("assets/image/logo_dana_blue.svg") ?>" alt="Dana Internal Logo" class="brand-image">
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <form id="login-form" action="<?= $api_login_submit ?>" method="post">
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <div class="modal fade" id="modal-default" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="modal-default-body"></div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- jQuery -->
        <script src="<?= base_url("assets/adminlte/plugins/jquery/jquery.min.js") ?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url("assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url("assets/adminlte/dist/js/adminlte.min.js") ?>"></script>

        <script src="<?= base_url("assets/js/login.js?v=".ASSET_VERSION) ?>"></script>

    </body>
</html>