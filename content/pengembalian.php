<?php
$queryPinjam = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, user.nama_lengkap, peminjaman.* FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota LEFT JOIN user ON user.id = peminjaman.id_user WHERE deleted_at = 0 ORDER BY id DESC");
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Transaksi Pengembalian</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-pengembalian" class="btn btn-primary">Tambah</a> <!-- href=link nya menuju kemana -->
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">
                            Data Berhasil ditambahkan
                        </div>
                    <?php endif ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger">
                            Data Berhasil dihapus
                        </div>
                    <?php endif ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Anggota</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl kembali</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php $no = 1;
                            while ($rowPinjam = mysqli_fetch_assoc($queryPinjam)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowPinjam['kode_transaksi'] ?></td>
                                    <td><?php echo $rowPinjam['nama_anggota'] ?></td>
                                    <td><?php echo $rowPinjam['tgl_pinjam'] ?></td>
                                    <td><?php echo $rowPinjam['tgl_kembali'] ?></td>
                                    <td><?php echo $rowPinjam['status'] ?></td>
                                    <td><?php echo $rowPinjam['nama_lengkap'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-pengembalian&detail=<?php echo $rowPinjam['id'] ?>" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                </div>
            </div>
        </div>
    </div>