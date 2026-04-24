<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'warden'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();
$pengguna = $controller->getAuth($conn);
$reports = $controller->getListTableName($conn, 'report', ' 1 = 1 ORDER BY tarikh DESC LIMIT 5', ',pelajar.*', 'LEFT JOIN pelajar ON (report.pelajar_id = pelajar.id)');
$nodata = false;
$hasIc = false;
if(isset($_POST['ic'])){
    $ic = $controller->valdata($conn, $_POST['ic']);
    $pelajar = $controller->getSingleData($conn, 'pelajar', "no_ic = '" . $ic . "'");
    if($pelajar == null){
        echo "<script>window.alert('Ic pelajar tidak ada dalam pangkalan data, sila cuba sekali lagi.')</script>";
        echo "<script>window.location = 'index.php'</script>";
    }

    $dataPelajar = $controller->getSingleData(
        $conn, 
        'permohonan', 
        " NOW() < tarikh_masuk AND pelajar.no_ic = '" . $ic . "'", 
        ',pelajar.id as pelajarId, pelajar.statuskeluar as statuskeluar, pelajar.nama as nama, permohonan_status.status as status, permohonan_status.class as class, pengesahan_warden.pengesahan as pengesahan, pengesahan_warden.class as pengesahanClass', 
        ' LEFT JOIN pelajar ON (permohonan.pelajar_id = pelajar.id) LEFT JOIN permohonan_status ON (permohonan.permohonan_status_id = permohonan_status.id) LEFT JOIN pengesahan_warden ON (permohonan.pengesahan_warden_id = pengesahan_warden.id)'
    );

    if($dataPelajar == null){
        $nodata = true;
    }
    $hasIc = true;
}


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

                        <?php
                            if($hasIc){ ?>
                        <div class="col-md-10 mx-auto">
                            <div class="card-box">

                                <h4 class="header-title mb-3">
                                    Maklumat Pelajar: <?= $ic?>
                                </h4>

                                <?php
                                    if($nodata){ ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <tr>
                                            <th colspan="2">
                                                <div class="alert alert-danger" role="alert">
                                                    Tiada permohonan cuti dibuat oleh pelajar ini.
                                                </div>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th class="fill">Pelajar</th>
                                            <td><?= $pelajar['nama']?></td>
                                        </tr>
                                        <tr>
                                            <th>No Matrik</th>
                                            <td><?= $pelajar['no_matrik']?></td>
                                        </tr>
                                        <tr>
                                            <th>No Bilik</th>
                                            <td><?= $pelajar['no_bilik']?></td>
                                        </tr>
                                        <tr>
                                            <th>No Phone</th>
                                            <td><?= $pelajar['no_tel']?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $pelajar['email']?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge badge-<?= ($pelajar['statuskeluar'] == 0) ? 'danger' : 'success'  ?>"><?= ($pelajar['statuskeluar'] == 0) ? 'Keluar' : 'Masuk'  ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <a class="btn btn-success btn-sm"
                                    href="../controller/controller.php?mod=updateLaporan&id=<?= $pelajar['id'] ?>">Diterima</a>

                                <?php } else { ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">

                                        <tr>
                                            <th class="fill">Pelajar</th>
                                            <td><?= $dataPelajar['nama']?></td>
                                        </tr>
                                        <tr>
                                            <th>Pengesahan Oleh</th>
                                            <td><?= $dataPelajar['pengesahan_oleh']?></td>
                                        </tr>
                                        <tr>
                                            <th>Alasan</th>
                                            <td><?= $dataPelajar['alasan']?></td>
                                        </tr>
                                        <tr>
                                            <th>Tarikh Keluar</th>
                                            <td><?= $dataPelajar['tarikh_keluar']?></td>
                                        </tr>
                                        <tr>
                                            <th>Tarikh Masuk</th>
                                            <td><?= $dataPelajar['tarikh_masuk']?></td>
                                        </tr>
                                        <tr>
                                            <th>Pengesahan Permohonan</th>
                                            <td><span
                                                    class="badge badge-<?= $dataPelajar['class']?>"><?= $dataPelajar['status']?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pengesahan Warden</th>
                                            <td><span
                                                    class="badge badge-<?= $dataPelajar['pengesahanClass']?>"><?= $dataPelajar['pengesahan']?></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <a class="btn btn-success btn-sm"
                                    href="../controller/controller.php?mod=updateLaporan&id=<?= $dataPelajar['pelajarId'] ?>">Diterima</a>
                                <?php } ?>
                                <button class="btn btn-primary btn-sm" onclick="window.print();">Cetak</button>
                                <a class="btn btn-danger btn-sm m-1" href="index.php">Carian semula</a>

                            </div>
                        </div><!-- end col-->

                        <?php } else { ?>
                        <div class="col-lg-5 mx-auto">
                            <div class="card">
                                <div class="card-header bg-success ">
                                    <h4 class="card-title text-white">Sila Scan Barcode Pelajar: </h4>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="">Barcode Pelajar</label>
                                            <input type="text" autofocus name="ic" class="form-control"
                                                autocomplete="off" placeholder="Barcode Pelajar">
                                        </div>
                                        <button class="btn btn-info btn-sm float-right">Hantar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <?php
                    if(!$hasIc){ ?>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">

                                <h4 class="header-title mb-3">
                                    <a class="float-right btn btn-primary btn-sm" href="report.php">Lihat Semua</a>
                                    Data Laporan Terkini
                                </h4>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Pelajar</th>
                                                <th>No Matrik</th>
                                                <th>No Bilik</th>
                                                <th>status</th>
                                                <th>tarikh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    if($reports != null){
                                        foreach($reports as $report){ ?>
                                            <tr>
                                                <th class="text-muted"><?= $report['nama'] ?></th>
                                                <th class="text-muted"><?= $report['no_matrik'] ?></th>
                                                <th class="text-muted"><?= $report['no_bilik'] ?></th>
                                                <td><span
                                                        class="badge badge-<?= ($report['status'] == 'keluar') ? 'danger' : 'success' ?>"><?= $report['status'] ?></span>
                                                </td>
                                                <th class="text-muted"><?= $report['tarikh'] ?></th>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <th colspan="5" class="text-muted">Tiada Laporan</th>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end col-->

                    </div>


                    <?php } ?>

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