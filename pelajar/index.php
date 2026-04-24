<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pelajar_id'])){
    session_destroy();

    echo "<script>window.location = '../login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pelajar = $controller->getAuth($conn);
$totalPermohonan = $controller->getCount($conn, 'permohonan', 'WHERE pelajar_id = ' . $pelajar['id']);
$totalPermohonanDalamPengesahan = $controller->getCount($conn, 'permohonan', 'WHERE pelajar_id = ' . $pelajar['id'] . ' AND permohonan_status_id = 1 OR pengesahan_warden_id = 1');
$totalPermohonanBerjaya = $controller->getCount($conn, 'permohonan', 'WHERE pelajar_id = ' . $pelajar['id'] . ' AND permohonan_status_id = 2 OR pengesahan_warden_id = 2');
$totalPermohonanDitolak = $controller->getCount($conn, 'permohonan', 'WHERE pelajar_id = ' . $pelajar['id'] . ' AND permohonan_status_id = 3 AND pengesahan_warden_id = 3');
$senaraiPermohonan = $controller->getListTableName(
    $conn, 
    'permohonan', 
    ' pelajar_id = '. $pelajar['id'] . ' AND NOW() < tarikh_masuk', 
    ', permohonan_status.status as status, permohonan_status.class as class, pengesahan_warden.pengesahan as pengesahan, pengesahan_warden.class as pengesahanClass', 
    ' LEFT JOIN permohonan_status ON (permohonan.permohonan_status_id = permohonan_status.id) LEFT JOIN pengesahan_warden ON (permohonan.pengesahan_warden_id = pengesahan_warden.id)'
);
$checkPermohonan = $controller->checkPermohonan($conn);

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'layout/head.php' ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <?php include 'layout/top-header.php' ?>

        <?php include 'layout/menu.php' ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-friends float-right m-0 h2 text-primary"></i>
                                <h6 class="text-muted text-uppercase mt-0">Permohonan</h6>
                                <h3 class="my-3" data-plugin="counterup"><?= number_format($totalPermohonan['total'], 0) ?></h3>
                                <span class="badge badge-success mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-file-alt float-right m-0 h2 text-warning"></i>
                                <h6 class="text-muted text-uppercase mt-0">Pengesahan</h6>
                                <h3 class="my-3"><span data-plugin="counterup"><?= number_format($totalPermohonanDalamPengesahan['total'], 0) ?></span></h3>
                                <span class="badge badge-danger mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-check float-right m-0 h2 text-success"></i>
                                <h6 class="text-muted text-uppercase mt-0">Permohonan Berjaya</h6>
                                <h3 class="my-3"><span data-plugin="counterup"><?= number_format($totalPermohonanBerjaya['total'], 0) ?></span></h3>
                                <span class="badge badge-pink mr-1"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fas fa-user-times float-right m-0 h2 text-danger"></i>
                                <h6 class="text-muted text-uppercase mt-0">Permohonan Ditolak</h6>
                                <h3 class="my-3" data-plugin="counterup"><?= number_format($totalPermohonanDitolak['total'], 0) ?></h3>
                                <span class="badge badge-warning mr-1"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                <div class="col-xl-4">
                    <div class="card-box">
                        
                        <h4 class="header-title mb-3">
                        Info Pelajar</h4>

                        <div class="inbox-widget">
                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <td><?= $pelajar['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Matrik</th>
                                        <td><?= $pelajar['no_matrik'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Ic</th>
                                        <td><?= $pelajar['no_ic'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Bilik</th>
                                        <td><?= $pelajar['no_bilik'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td><?= $pelajar['agama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td><?= $pelajar['alamat'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Tel</th>
                                        <td><?= $pelajar['no_tel'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $pelajar['email'] ?></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        </div>
                    </div>
                </div><!-- end col-->

                <div class="col-xl-8">
                    <div class="card-box">

                        <h4 class="header-title mb-3">
                        <button class="float-right btn btn-primary btn-sm" onclick="window.location.href='permohonan.php'">Lihat</button>
                        Senarai permohonan</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Alasan</th>
                                        <th>Tarikh Keluar</th>
                                        <th>Tarikh Permohonan</th>
                                        <th>Pengesahan KJ</th>
                                        <th>Pengesahan Warden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($senaraiPermohonan != null){
                                        foreach($senaraiPermohonan as $permohonan){ ?>
                                            <tr>
                                                <th class="text-muted"><?= $permohonan['alasan'] ?></th>
                                                <td><?= $permohonan['tarikh_keluar'] ?></td>
                                                <td><?= $permohonan['tarikh_permohonan'] ?></td>
                                                <td><span class="badge badge-<?= $permohonan['class'] ?>"><?= $permohonan['status'] ?></span></td>
                                                <td><span class="badge badge-<?= $permohonan['pengesahanClass'] ?>"><?= $permohonan['pengesahan'] ?></span></td>
                                            </tr>
                                    <?php } } else { ?>
                                        <tr>
                                            <th colspan="5" class="text-muted">Tiada Senarai Permohonan</th>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end col-->

            </div>


                </div> <!-- end container-fluid -->

            </div> <!-- end content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            Politeknik Balik Pulau
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <?php include 'layout/script.php' ?>

</body>

</html>