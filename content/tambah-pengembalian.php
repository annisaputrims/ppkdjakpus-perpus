<?php



if (isset($_POST['simpan'])) {

    $id = isset($_GET['edit']) ? $_GET['edit'] : '';


    // $kode_transaksi = $_POST['kode_transaksi'];
    $id_peminjaman = $_POST['id_peminjaman'];
    // $id_kategori = $_POST['id_kategori'];
    // $id_anggota = $_POST['id_anggota'];
    $id_user = $_POST['id_user'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $denda = $_POST['denda'];
    $terlambat = $_POST['terlambat'];

    if (!$id) {
        // $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi,id_kategori,id_anggota,id_user,tgl_pinjam,tgl_kembali, status) VALUES ('$kode_transaksi','$id_anggota','$id_user','$tgl_pinjam','$tgl_kembali','1')");

        $insertPengembalian = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman,denda,tgl_pengembalian,terlambat)VALUES('$id_peminjaman','$denda','$tgl_kembali','$terlambat')");


        header("location:index.php?pg=pengembalian");
        $updatePeminjaman = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id=$id_peminjaman");
    }
}

// mysqli query diberikan setiap akan dilakukan perintah/query 
// sedangkan $koneksi menghubungkan dari config-koneksi.php

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

//KODE TRANSAKSI
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 1 ORDER BY id DESC");

?>

<?php if (isset($_GET['detail'])): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Detail Transaksi Pengembalian</div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo date('D, d M Y', strtotime($rowDetail['tgl_kembali'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['nama_lengkap'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo getStatus($rowDetail['status']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tabel ajah untuk detail nya -->
                        <div class="mb-5 mt-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                </tr>
                                <?php $no = 1;
                                while ($rowDetail = mysqli_fetch_assoc($queryDetail)): ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $rowDetail['nama_kategori'] ?></td>
                                        <td><?php echo $rowDetail['judul'] ?></td>
                                    </tr>
                                <?php endwhile ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>


    <div class="container mt-5"> <!-- mt=margin-top -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Transaksi Pengembalian</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pengembalian</label>
                                </div>
                                <div class="col-sm-3">
                                    <input id="tanggalInput" type="date" class="form-control" name="tgl_kembali" value="">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="" value="<?php echo ($_SESSION['NAMA_LENGKAP'] ?? '') ?>" readonly></input>
                                    <input type="hidden" name="id_user" value="<?php echo ($_SESSION['ID_USER'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mt-5 mb-5">
                                <div class="row mb-5">
                                    <div class="col-sm-2">
                                        <label for="">Kode Peminjaman</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="id_peminjaman" id="kode_peminjaman" class="form-control">
                                            <option value="">Pilih Kode Peminjaman</option>
                                            <?php while ($rowPeminjaman = mysqli_fetch_assoc($queryPeminjaman)): ?>
                                                <option value="<?php echo $rowPeminjaman['id'] ?>"><?php echo $rowPeminjaman['kode_transaksi'] ?></option>
                                            <?php endwhile ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Nama Anggota</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Nama Anggota" type="text" readonly id="nama_anggota" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Tanggal Pinjam</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Tanggal Pinjam" type="text" readonly id="tgl_pinjam" value="" class="form-control" name="tgl_pinjam">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Tanggal kembali</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="Tanggal kembali" type="text" readonly id="tgl_kembali" value="" class="form-control" name="tgl_kembali">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="">Keterlambatan</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input placeholder="jumlah hari keterlambatan" type="text" readonly id="terlambat" value="" class="form-control">
                                            <input type="hidden" name="denda" id="denda">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Get data Kategori Buku dan Buku -->

                            <input type="hidden" id="tahun_terbit">

                            <div class="mt-5 mb-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <table>
                                            <div align="right" class="total-denda" style="">
                                            </div>
                                        </table>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>