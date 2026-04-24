<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pelajar_id'])){
    session_destroy();

    echo "<script>window.location = '../login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pelajar = $controller->getAuth($conn);
$senaraiPermohonan = $controller->getListTableName(
    $conn, 
    'permohonan', 
    ' pelajar_id = '. $pelajar['id'], 
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
                                <h4 class="page-title">Permohonan</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">
                                <?php 
                                    if($checkPermohonan){ ?>
                                        <button class="float-right btn btn-primary btn-sm disabled" >Permohonan Baru</button>
                                    <?php } else { ?>
                                        <button class="float-right btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#exampleModal">Permohonan Baru</button>
                                    <?php } ?>
                                    Senarai permohonan
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Alasan</th>
                                                <th>Tarikh Keluar</th>
                                                <th>Tarikh Masuk</th>
                                                <th>Tarikh Permohonan</th>
                                                <th>Status</th>
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
                                                <td><?= $permohonan['tarikh_masuk'] ?></td>
                                                <td><?= $permohonan['tarikh_permohonan'] ?></td>
                                                <td><span class="badge badge-<?= $permohonan['class'] ?>"><?= $permohonan['status'] ?></span></td>
                                                <td><span class="badge badge-<?= $permohonan['pengesahanClass'] ?>"><?= $permohonan['pengesahan'] ?></span></td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <th colspan="6" class="text-muted">Tiada Senarai Permohonan</th>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end col-->

                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Permohonan Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="../controller/controller.php?mod=permohonanbaru">
                                    <div class="modal-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Tarih Keluar</label>
                                                <input type="date" class="form-control" required name="tarikh_keluar">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tarikh Masuk</label>
                                                <input type="date" class="form-control" required name="tarikh_masuk">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Alasan</label>
                                            <textarea name="alasan" class="form-control" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Hantar</button>
                                    </div>
                                </form>
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