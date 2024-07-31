<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    //jika parameter edit ada maka update, kalo gaada = tambah 
    $id = (isset($_GET['edit'])) ? $_GET['edit'] : '';

    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']); //enkripsi password menggunakan sha1

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO user (nama lengkap, email, password) VALUES ('$nama_lengkap', '$email, '$password')");
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET nama_lengkap='$nama_lengkap', email = '$email', password = '$password' WHERE id = '$id'");
    }
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php
    header("Location:?pg=user&tambah=berhasil");
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("Location:?pg=user&hapus=berhasil");
}
?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah User</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?php echo ($rowEdit['nama_lengkap'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo ($rowEdit['email'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan"> <!-- value = inputan yg akan terlihat kepada user -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>