<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'warden'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();
$pengguna = $controller->getAuth($conn);

$reports = $controller->getListTableName($conn, 'report', ' 1 = 1 ORDER BY tarikh DESC', ',pelajar.*', 'LEFT JOIN pelajar ON (report.pelajar_id = pelajar.id)');


?>

<!DOCTYPE html>
<html lang="en">

<?php include 'layout/head.php' ?>
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/datatables.min.css" />
<style>
.btn-success{
    color: #fff !important;
    background-color: #1bb99a !important;
    border-color: #1bb99a !important;
}
</style>
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
                                    <!-- <button class="float-right btn btn-primary btn-sm">Lihat</button> -->
                                    Laporan
                                </h4>

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Pelajar</th>
                                                <th>No Matrik</th>
                                                <th>No Bilik</th>
                                                <th>Status</th>
                                                <th>Tarikh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    if($reports != null){
                                        foreach($reports as $report){ ?>
                                            <tr>
                                                <td class="text-muted"><?= $report['nama'] ?></td>
                                                <td class="text-muted"><?= $report['no_matrik'] ?></td>
                                                <td class="text-muted"><?= $report['no_bilik'] ?></td>
                                                <td><span
                                                        class="badge badge-<?= ($report['status'] == 'keluar') ? 'danger' : 'success' ?>"><?= $report['status'] ?></span>
                                                </td>
                                                <td class="text-muted"><?= $report['tarikh'] ?></td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="5" class="text-muted">Tiada Laporan</td>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/datatables.min.js">
    </script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text : '<i class="mdi mdi-file-find"></i> Excel',
                    title: 'Laporan Keluar Masuk Pelajar',
                    className: 'btn btn-success',
                },
            ]
        });
    });
    </script>
</body>

</html>