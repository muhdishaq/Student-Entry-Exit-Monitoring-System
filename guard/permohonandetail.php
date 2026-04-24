<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'ketua jabatan'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();
$pengguna = $controller->getAuth($conn);

if(!isset($_GET['id'])){
    echo "<script>window.location = '../ketua-jabatan/index.php'</script>";
}
$permohonan = $controller->getSingleData($conn, 'permohonan', ' permohonan.id = ' . $_GET['id'], ', permohonan.id as permohonanId, pelajar.*, permohonan_status.status as status, permohonan_status.class as class, pengesahan_warden.pengesahan as pengesahan, pengesahan_warden.class as pengesahanClass', 
' LEFT JOIN pelajar ON (permohonan.pelajar_id = pelajar.id) LEFT JOIN permohonan_status ON (permohonan.permohonan_status_id = permohonan_status.id) LEFT JOIN pengesahan_warden ON (permohonan.pengesahan_warden_id = pengesahan_warden.id)');

$isWeekend = $controller->isWeekend();
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
                                <h4 class="page-title">Pelajar : <?= $permohonan['nama'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Pelajar Detail</th>
                                                </tr>
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?= $permohonan['nama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No Matrik</th>
                                                    <td><?= $permohonan['no_matrik'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No Ic</th>
                                                    <td><?= $permohonan['no_ic'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No Bilik</th>
                                                    <td><?= $permohonan['no_bilik'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Agama</th>
                                                    <td><?= $permohonan['agama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?= $permohonan['alamat'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No Tel</th>
                                                    <td><?= $permohonan['no_tel'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Permohonan</th>
                                                </tr>
                                                <tr>
                                                    <th>Alasan</th>
                                                    <td><?= $permohonan['alasan'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tarikh Keluar</th>
                                                    <td><?= $permohonan['tarikh_keluar'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tarikh Masuk</th>
                                                    <td><?= $permohonan['tarikh_masuk'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tarih Permohonan</th>
                                                    <td><?= $permohonan['tarikh_permohonan'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pengesahan Oleh</th>
                                                    <td><span class=""><?= $permohonan['pengesahan_oleh'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th>Status Permohonan</th>
                                                    <td><span class="badge badge-<?= $permohonan['class'] ?>"><?= $permohonan['status'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th>Pengesahan Warden</th>
                                                    <td><span class="badge badge-<?= $permohonan['pengesahanClass'] ?>"><?= $permohonan['pengesahan'] ?></span></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="form-group p-3">
                                        <input type="hidden" name="id" value="<?= $permohonan['id'] ?>">
                                        <a class="btn btn-primary btn-sm" href="index.php">Back</a>

                                    </div>
                                </div>
                            </div>
                        </div>
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