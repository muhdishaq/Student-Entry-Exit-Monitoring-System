<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'admin'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

if(!isset($_GET['id'])){
    echo "<script>window.location = '../admin/pengguna.php'</script>";
}
$pengguna = $controller->getSingleData($conn, 'pengguna', ' id = ' . $_GET['id']);

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
                                <h4 class="page-title">Pengguna : <?= $pengguna['nama'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <form action="../controller/controller.php?mod=kemaskinipengguna" method="post">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td><input type="text" name="nama" class="form-control" required
                                                                value="<?= $pengguna['nama'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Role</th>
                                                        <td>
                                                            <select name="role" required class="form-control">
                                                                <option value="">Sila pilih</option>
                                                                <option
                                                                    <?= ($pengguna['role'] == 'ketua jabatan') ? 'selected' : '' ?>
                                                                    value="ketua jabatan">Ketua Jabatan</option>
                                                                <option
                                                                    <?= ($pengguna['role'] == 'warden') ? 'selected' : '' ?>
                                                                    value="warden">Warden</option>
                                                                <option
                                                                    <?= ($pengguna['role'] == 'guard') ? 'selected' : '' ?>
                                                                    value="guard">Guard</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td><input type="text" name="email" class="form-control"
                                                                required value="<?= $pengguna['email'] ?>"></td>
                                                    </tr>

                                                </thead>
                                            </table>
                                        </div>
                                        <div class="form-group p-3">
                                            <input type="hidden" name="id" value="<?= $pengguna['id'] ?>">
                                            <a class="btn btn-danger btn-sm" href="pengguna.php">Back</a>
                                            <button class="btn btn-success btn-sm" type="submit">Kemaskini</button>
                                        </div>
                                    </form>
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