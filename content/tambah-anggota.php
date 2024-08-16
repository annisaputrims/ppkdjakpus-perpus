<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id             = (isset($_GET['edit'])) ? $_GET['edit'] : '';
    $nisn           = $_POST['nisn'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $no_telp        = $_POST['no_telp'];
    $alamat         = $_POST['alamat'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO anggota (nisn, nama_lengkap, jenis_kelamin, no_telp, alamat) VALUES ('$nisn', '$nama_lengkap', '$jenis_kelamin', '$no_telp', '$alamat')");
        header("Location:?pg=anggota&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE anggota SET nisn='$nisn', nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin', no_telp = '$no_telp', alamat = '$alamat' WHERE id = '$id'");
        header("Location:?pg=anggota&ubah=berhasil");
    }
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php

}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = '$id'");
    header("Location:?pg=anggota&hapus=berhasil");
}
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah Anggota</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="<?php echo ($rowEdit['nisn'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?php echo ($rowEdit['nama_lengkap'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">No Telp.</label>
                            <input type="number" name="no_telp" class="form-control" value="<?php echo ($rowEdit['no_telp'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat</label>
                            <textarea name="alamat" id="" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan"> <!-- value = inputan yg akan terlihat kepada user -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>