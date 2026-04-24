<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'admin'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

if(!isset($_GET['id'])){
    echo "<script>window.location = '../admin/pelajar.php'</script>";
}
$pelajar = $controller->getSingleData($conn, 'pelajar', ' id = ' . $_GET['id']);

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
                                <h4 class="page-title">Pelajar : <?= $pelajar['nama'] ?></h4>
                            </div>
                        </div>
                    </div>
 
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <form action="../controller/controller.php?mod=kemaskinipelajar" method="post">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><input type="text" name="nama" class="form-control" required value="<?= $pelajar['nama'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>No Matrik</th>
                                                    <td><input type="text" name="no_matrik" class="form-control" required value="<?= $pelajar['no_matrik'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>No Ic</th>
                                                    <td><input type="text" name="no_ic" class="form-control" required value="<?= $pelajar['no_ic'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>No Bilik</th>
                                                    <td><input type="text" name="no_bilik" class="form-control" required value="<?= $pelajar['no_bilik'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>Agama</th>
                                                    <td><input type="text" name="agama" class="form-control" required value="<?= $pelajar['agama'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><input type="text" name="alamat" class="form-control" required value="<?= $pelajar['alamat'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>No Tel</th>
                                                    <td><input type="text" name="no_tel" class="form-control" required value="<?= $pelajar['no_tel'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><input type="email" name="email" class="form-control" required value="<?= $pelajar['email'] ?>"></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="form-group p-3">
                                        <input type="hidden" name="id" value="<?= $pelajar['id'] ?>">
                                        <a class="btn btn-danger btn-sm" href="pelajar.php">Back</a>
                                        <button class="btn btn-success btn-sm" type="submit" >Kemaskini</button>
                                    </div>
                                    </form>
                                </div>
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