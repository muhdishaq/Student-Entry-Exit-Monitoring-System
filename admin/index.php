<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'admin'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pengguna = $controller->getAuth($conn);
$jumlahPelajar = $controller->getCount($conn, 'pelajar');
$jumlahKJ = $controller->getCount($conn, 'pengguna', ' WHERE role = "ketua jabatan"');
$jumlahWarden = $controller->getCount($conn, 'pengguna', ' WHERE role = "warden"');
$jumlahGuard = $controller->getCount($conn, 'pengguna', ' WHERE role = "guard"');
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'layout/head.php' ?>

<body>

    <div id="wrapper">

        <?php include 'layout/top-header.php' ?>

        <?php include 'layout/menu.php' ?>

        <div class="content-page">
            <div class="content">


                <div class="container-fluid">


                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-friends float-right m-0 h2 text-primary"></i>
                                <h6 class="text-muted text-uppercase mt-0">Pelajar</h6>
                                <h3 class="my-3" data-plugin="counterup"><?= $jumlahPelajar['total'] ?></h3>
                                <span class="badge badge-success mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-times float-right m-0 h2 text-danger"></i>
                                <h6 class="text-muted text-uppercase mt-0">Ketua Jabatan</h6>
                                <h3 class="my-3"><span data-plugin="counterup"><?= $jumlahKJ['total'] ?></span></h3>
                                <span class="badge badge-danger mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-check float-right m-0 h2 text-success"></i>
                                <h6 class="text-muted text-uppercase mt-0">Warden</h6>
                                <h3 class="my-3"><span data-plugin="counterup"><?= $jumlahWarden['total'] ?></span></h3>
                                <span class="badge badge-pink mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-file-alt float-right m-0 h2 text-warning"></i>
                                <h6 class="text-muted text-uppercase mt-0">Guard</h6>
                                <h3 class="my-3" data-plugin="counterup"><?= $jumlahGuard['total'] ?></h3>
                                <span class="badge badge-warning mr-1"></span>
                            </div>
                        </div>
                    </div>
                </div> 

            </div> 
			
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            Politeknik Balik Pulau
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <?php include 'layout/script.php' ?>

</body>

</html>