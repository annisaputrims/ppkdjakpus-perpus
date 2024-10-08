<?php
$queryUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level ON level.id = user.id_level ORDER BY id DESC");
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Data User</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-user" class="btn btn-primary">Tambah</a> <!-- href=link nya menuju kemana -->
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php $no = 1;
                            while ($rowUser = mysqli_fetch_assoc($queryUser)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowUser['nama_lengkap'] ?></td>
                                    <td><?php echo $rowUser['email'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-user&edit=<?php echo $rowUser['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                        <a href="?pg=tambah-user&delete=<?php echo $rowUser['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('apakah anda yakin akan menghapus data?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                        <?php

                        $no = 1;
                        while ($rowUser = mysqli_fetch_assoc($queryUser)) : ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $rowUser['nama_level'] ?></td>
                                <td><?php echo $rowUser['nama_lengkap'] ?></td>
                                <td><?php echo $rowUser['email'] ?></td>
                                <td>
                                    <a href="?pg=tambah-user&edit<?php echo $rowUser['id'] ?>" class="btn btn-sm btn-success">EDIT</a>
                                    <a onclick="return confirm('apakah anda yakin mengahpus data ini??')" href="?pg=tambah-user&delete=<?php echo $rowUser['id'] ?>" class="brtn btn-sm btn">Delete</a>
                                </td>
                            </tr>
                    </table>
                <?php endwhile ?>
                </div>
            </div>
        </div>
    </div>