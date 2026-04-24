<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Seems</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="TISSAC" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="theme/images/favicon.ico">

    <!-- App css -->
    <link href="theme/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="theme/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="theme/css/app.min.css" rel="stylesheet" type="text/css"  id="app-stylesheet" />
        <style>
        .bg-training2 {
            background-image: url(https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1502&q=80);
            background-size: cover;
            background-repeat: no-repeat;
        }
        </style>
</head>

<body class="bg-training2">

    <div class="account-pages pt-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-6">
                    <div class="account-card-box">
                        <div class="card mb-0">
                            <div class="card-body p-4">

                                <div class="text-center">
                                    <div class="my-3">
                                        <a href="index.html">
                                        </a>
                                    </div>
                                    <h5 class="text-muted text-uppercase py-3 font-20">Selamat Datang<br>Student Entry & Exit Monitoring System</h5>
                                </div>

                                <form method="POST" action="controller/controller.php?mod=login">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                        <label >Email</label>
                                        <input  type="text" placeholder="Masukkan Email" class="form-control " name="email" required >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label >Kata Laluan</label>
                                            <input id="password" type="password" placeholder="Masukkan Kata Laluan" class="form-control " name="password" required autocomplete="new-password">

                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-block waves-effect waves-light" type="submit"> Hantar </button>
                                    </div>

                                </form>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="theme/js/vendor.min.js"></script>

<!-- App js -->
<script src="theme/js/app.min.js"></script>

</body>

</html>