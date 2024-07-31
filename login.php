<?php 
session_start(); //fungsinya untuk menyimpan data login sementara user di browser
include 'config/koneksi.php'; //fungsi include adalah untuk memasukkan file atau yg lain dari direktori yang dituju

if (isset($_POST['login'])) { //fungsi post adalah untuk mengaambil inputan dari database user
    $email = $_POST['email']; //kalo pake fungsi get inputann kelihatan di http, kalo post tidak jadi antisipasi untuk kebobolan password   
    $password = sha1($_POST['password']);

    $queryLogin = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'"); //'$_email diambil dari value email, query adalah perintah untuk mengeksekusi database mau diapakan
    if (mysqli_num_rows($queryLogin) > 0) {
        $dataUser = mysqli_fetch_assoc($queryLogin);
        if ($password == $dataUser['password']) {
            $_SESSION['NAMA_LENGKAP'] = $dataUser['nama_lengkap']; //$_SESSION adalah untuk membuat array
            $_SESSION['ID_USER'] = $dataUser['id']; //(==)artinya adalah sama setara atau bersamaan, dalam artian jika kondisi kedua variabel benar berarti benar 
            header("location:index.php"); //location adalah untuk memanggil direktori lokasi file yang dituju
        }
    } else {
        header("location:index.php?error=login"); //ini kondisi jika gagal login
    }
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Form</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
 </head>
 <body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-8"> 
                <!-- colom small 10 artinya -->
                <div class="card">
                    <div class="card-header">Login Form</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" name="email" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="login" id="" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>