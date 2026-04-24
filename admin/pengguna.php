<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] != 'admin'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pengguna = $controller->getAuth($conn);
$senaraiPengguna = $controller->getListTableName($conn, 'pengguna', ' role != "admin"');

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
                                <h4 class="page-title">Pengguna</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">
                                    <button class="float-right btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#exampleModal">Tambah Pengguna</button>
                                    Senarai Pengguna 
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    if($senaraiPengguna != null){
                                        $bil = 1;
                                        foreach($senaraiPengguna as $pengguna){ ?>
                                            <tr>
                                                <th class="text-muted"><?= $bil++ ?></th>
                                                <th class="text-muted"><?= $pengguna['nama'] ?></th>
                                                <td><?= $pengguna['email'] ?></td>
                                                <td><?= $pengguna['role'] ?></td>
                                                <td width="100">
                                                    <a class="btn btn-warning btn-sm" href="penggunadetail.php?id=<?= $pengguna['id'] ?>">Kemaskini</a>
                                                    <a class="btn btn-danger btn-sm" href="../controller/controller.php?mod=padampengguna&id=<?= $pengguna['id'] ?>" onclick="return confirm('Anda pasti untuk padam data pengguna ini ?')">Padam</a>
                                                </td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <th colspan="5" class="text-muted">Tiada Senarai pengguna</th>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Pengguna Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="../controller/controller.php?mod=tambahpengguna">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" required placeholder="nama">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" class="form-control" placeholder="Email" required name="email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Password" required name="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" required class="form-control">
                                                <option value="">Sila pilih</option>
                                                <option value="ketua jabatan">Ketua Jabatan</option>
                                                <option value="warden">Warden</option>
                                                <option value="guard">Guard</option>
                                            </select>
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