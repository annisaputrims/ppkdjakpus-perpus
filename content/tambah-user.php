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
    $id_level = $_POST['id_level'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, email, password, id_level) VALUES ('$nama_lengkap', '$email', '$password', '$id_level')");
        header("Location:?pg=user&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET nama_lengkap='$nama_lengkap', email = '$email', password = '$password', id_level = '$id_level' WHERE id = '$id'");
        header("Location:?pg=user&ubah=berhasil");
    }
       
    // mysqli query diberikan setiap akan dilakukan perintah/query 
    // sedangkan $koneksi menghubungkan dari config-koneksi.php
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("Location:?pg=user&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

?>

<div class="container mt-5"> <!-- mt=margin-top -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah User</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Level</label>
                            <select name="id_level" id="" class="form-control">
                                <option value="">Pilih Level</option>
                                <?php while ($rowLevel = mysqli_fetch_assoc($level)) : ?>
                                    <option <?php echo isset($rowEdit['id_level']) ? ($rowEdit['id_level'] == $rowLevel['id']) ? 'selected' : '' : '' ?> value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
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