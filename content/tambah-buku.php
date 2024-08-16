<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id = (isset($_GET['edit'])) ? $_GET['edit'] : '';
    $id_kategori = $_POST['id_kategori'];
    $judul = $_POST['judul'];
    $jumlah = $_POST['jumlah'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penulis = $_POST['penulis'];


    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO buku (id_kategori, judul, jumlah, penerbit, tahun_terbit, penulis) VALUES ('$id_kategori', '$judul', '$jumlah', '$penerbit', '$tahun_terbit', '$penulis')");
        header("Location:?pg=buku&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE buku SET id='$id_kategori', judul = '$judul', jumlah = '$jumlah', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', penulis = '$penulis' WHERE id = '$id'");
        header("Location:?pg=buku&ubah=berhasil");
    }
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php

}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM buku WHERE id = '$id'");
    header("Location:?pg=buku&hapus=berhasil");
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");

?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah Buku</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="id_kategori" id="" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php while ($rowKategori = mysqli_fetch_assoc($kategori)) : ?>
                                    <option <?php echo isset($rowEdit['id_kategori']) ? ($rowEdit['id_kategori'] == $rowKategori['id']) ? 'selected' : '' : '' ?> value="<?php echo $rowKategori['id'] ?>"><?php echo $rowKategori['nama_kategori'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" value="<?php echo ($rowEdit['judul'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">jumlah</label>
                            <input type="text" name="jumlah" class="form-control" value="<?php echo ($rowEdit['jumlah'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?php echo ($rowEdit['penerbit'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" class="form-control" value="<?php echo ($rowEdit['tahun_terbit'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" value="<?php echo ($rowEdit['penulis'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan"> <!-- value = inputan yg akan terlihat kepada user -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>