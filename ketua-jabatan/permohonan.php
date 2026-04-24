<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'ketua jabatan'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pengguna = $controller->getAuth($conn);
$senaraiPermohonan = $controller->getListTableName(
    $conn, 
    'permohonan', 
    '1=1', 
    ', pelajar.nama as nama, permohonan_status.status as status, permohonan_status.class as class, pengesahan_warden.pengesahan as pengesahan, pengesahan_warden.class as pengesahanClass', 
    ' LEFT JOIN pelajar ON (permohonan.pelajar_id = pelajar.id) LEFT JOIN permohonan_status ON (permohonan.permohonan_status_id = permohonan_status.id) LEFT JOIN pengesahan_warden ON (permohonan.pengesahan_warden_id = pengesahan_warden.id)'
);
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

                        <div class="col-md-12">
                            <div class="card-box">

                                <h4 class="header-title mb-3">
                                    <button class="float-right btn btn-primary btn-sm">Lihat</button>
                                    Senarai Permohonan
                                </h4>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Pelajar</th>
                                                <th>Alasan</th>
                                                <th>Tarikh Keluar</th>
                                                <th>Tarikh Permohonan</th>
                                                <th>Status</th>
                                                <th>Pengesahan Warden</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    if($senaraiPermohonan != null){
                                        foreach($senaraiPermohonan as $permohonan){ ?>
                                            <tr>
                                                <th class="text-muted"><?= $permohonan['nama'] ?></th>
                                                <th class="text-muted"><?= $permohonan['alasan'] ?></th>
                                                <td><?= $permohonan['tarikh_keluar'] ?></td>
                                                <td><?= $permohonan['tarikh_permohonan'] ?></td>
                                                <td><span
                                                        class="badge badge-<?= $permohonan['class'] ?>"><?= $permohonan['status'] ?></span>
                                                </td>
                                                <td><span
                                                        class="badge badge-<?= $permohonan['pengesahanClass'] ?>"><?= $permohonan['pengesahan'] ?></span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm text-white" href="permohonandetail.php?id=<?= $permohonan['id'] ?>">Detail</a>
                                                </td>
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