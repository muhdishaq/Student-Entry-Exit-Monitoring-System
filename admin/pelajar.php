<?php 

include '../controller/controller.php';

if(!isset($_SESSION['pengguna_id']) && $_SESSION['pengguna_role'] == 'admin'){
    session_destroy();

    echo "<script>window.location = 'login.php'</script>";
}

$controller = new controller();
$conn = $controller->open();

$pelajar = $controller->getAuth($conn);
$senaraiPelajar = $controller->getListTableName($conn, 'pelajar');

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
                                <h4 class="page-title">Pelajar</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">
                                    <button class="float-right btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#exampleModal">Tambah pelajar</button>
                                    Senarai Pelajar
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama</th>
                                                <th>No Matrik</th>
                                                <th>No Bilik</th>
                                                <th>No Tel</th>
                                                <th>Alamat</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    if($senaraiPelajar != null){
                                        $bil = 1;
                                        foreach($senaraiPelajar as $pelajar){ ?>
                                            <tr>
                                                <th class="text-muted"><?= $bil++ ?></th>
                                                <th class="text-muted"><?= $pelajar['nama'] ?></th>
                                                <td><?= $pelajar['no_matrik'] ?></td>
                                                <td><?= $pelajar['no_bilik'] ?></td>
                                                <td><?= $pelajar['no_tel'] ?></td>
                                                <td><?= $pelajar['alamat'] ?></td>
                                                <td width="100">
                                                    <a class="btn btn-warning btn-sm" href="pelajardetail.php?id=<?= $pelajar['id'] ?>">Kemaskini</a>
                                                    <a class="btn btn-danger btn-sm" href="../controller/controller.php?mod=padampelajar&id=<?= $pelajar['id'] ?>" onclick="return confirm('Anda pasti untuk padam data pelajar ini ?')">Padam</a>
                                                </td>
                                            </tr>
                                            <?php } } else { ?>
                                            <tr>
                                                <th colspan="5" class="text-muted">Tiada Senarai pelajar</th>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">pelajar Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="../controller/controller.php?mod=tambahpelajar">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" required placeholder="nama">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>No Matrik</label>
                                                <input type="text" class="form-control" placeholder="No Matrik" required name="no_matrik">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>No Ic</label>
                                                <input type="text" class="form-control" placeholder="No Ic" required name="no_ic">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>No Bilik</label>
                                                <input type="text" class="form-control" placeholder="No Bilik" required name="no_bilik">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Agama</label>
                                                <input type="text" class="form-control" placeholder="Agama" required name="agama">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" class="form-control" cols="30" rows="3" placeholder="Alamat"></textarea>
                                        </div><div class="form-group">
                                            <label>No Telefon</label>
                                            <input type="text" name="no_tel" class="form-control" required placeholder="No Telefon">
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