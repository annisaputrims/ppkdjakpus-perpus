<?php
session_start();
ob_start();
include 'config/koneksi.php';
include 'function/helper.php';

// 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome! </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        nav.menu {
            background-color: lightgray !important;
            box-shadow: 0 0 3px #000;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="menu navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">PERPUSTAKAAN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?pg=home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?pg=peminjaman">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?pg=pengembalian">Pengembalian</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Master data
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="?pg=buku" class="dropdown-item">Buku</a>
                                </li>
                                <li>
                                    <a href="?pg=kategori" class="dropdown-item">Kategori</a>
                                </li>
                                <li>
                                    <a href="?pg=anggota" class="dropdown-item">Anggota</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a href="?pg=user" class="dropdown-item">User</a>
                                </li>
                                <li>
                                    <a href="?pg=level" class="dropdown-item">Level</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-info" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- content here -->
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists('content/' . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            } else {
                echo 'not found';
            }
        } else {
            include 'content/home.php';
        }
        ?>
        <!-- end content -->
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.js"></script>

    <script>
        $('#id_kategori').change(function() {
            let id = $(this).val(),
                option = "";
            $.ajax({
                url: `ajax/get-buku.php?id_kategori=${id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    option += "<option value=''>Pilih Buku</option>"
                    $.each(data, function(key, value) {
                        let tahun_terbit = $('#tahun_terbit').val(value.tahun_terbit);
                        option += "<option value=" + value.id + ">" + value.judul + "</option>"
                    });
                    $('#id_buku').html(option);
                }
            })
        });

        $('#tambah-row').click(function() {
            if ($('#id_kategori').val() == "") {
                alert('Mohon pilih kategori buku terlebih dahulu');
                return false;
            }
            if ($('id_buku').val() == "") {
                alert('Mohon pilih buku terlebih dahulu');
                return false;
            }
            let nama_kategori = $('#id_kategori').find('option:selected').text(),
                nama_buku = $('#id_buku').find('option:selected').text(),
                tahun_terbit = $('#tahun_terbit').val(),
                id_kategori = $('#id_kategori').val(),
                id_buku = $('#id_buku').val();


            let tbody = $('tbody');
            let no = tbody.find('tr').length + 1;
            let table = "<tr>";
            table += "<td>" + no + "</td>";
            table += `<td>${nama_kategori} <input type='hidden' name='id_kategori[]' value=${id_kategori}></td>`;
            table += "<td>" + nama_buku + " <input type='hidden' name='id_buku[]' value='" + id_buku + "'></td>";
            table += "<td>" + tahun_terbit + "</td>";
            table += "<td><button type='button' class='remove btn btn-sm btn-danger'>Delete</button></td>";
            table += "</tr>";
            tbody.append(table);

            $('.remove').click(function() {
                $(this).closest('tr').remove();
            });
        });
        
        $('#kode_peminjaman').change(function() {
            let id = $(this).val();
            $.ajax({
                url: "ajax/get-data-transaksi.php?kode_transaksi=" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // console.log("nilai sebelum di looping", data)
                    $('#nama_anggota').val(data.data.nama_lengkap)
                    $('#tgl_pinjam').val(data.data.tgl_pinjam)
                    $('#tgl_kembali').val(data.data.tgl_kembali)

                    let tgl_kembali = new moment(data.data.tgl_kembali)
                    let tgl_pengembalian = new moment('2024-08-10')
                    let selisih = tgl_pengembalian.diff(tgl_kembali, 'days');
                    if (selisih < 0) {
                        selisih = 0;
                    }
                    let denda = 100000;
                    let totalDenda = selisih * denda;
                    $('.total-denda').html("<h5>Total denda sebesar Rp." + totalDenda.toLocaleString('id-ID') + "</h5>");
                    $('#denda').val(totalDenda);
                    console.log("Rp. ", totalDenda.toLocaleString('id-ID'));
                    $('#terlambat').val(selisih)



                    let tbody = $('tbody'),
                        newRow = "";
                    let no = 1;
                    $.each(data.detail_pinjam, function(key, val) {
                        // console.log("nilai sesudah di looping", val);
                        newRow += "<tr>";
                        newRow += "<td>" + no++ + "</td>";
                        newRow += "<td>" + val.nama_kategori + "</td>";
                        newRow += "<td>" + val.judul + "</td>";
                        newRow += "<td>" + val.tahun_terbit + "</td>";
                        newRow += "</tr>";
                    });
                    tbody.html(newRow);





                }
            })
        });
        // let tanggalSekarang = new Date();
        // let formatIndonesia = new Intl.DateTimeFormat('id-ID', {
        //     year: 'numeric',
        //     month: '2-digit',
        //     day: '2-digit'
        // }).format(tanggalSekarang);


        // let tanggal_kembali = new moment(tgl_kembali);
        // let tanggal_pengembalian = new moment(tgl_pengembalian);

        // console.log(selisih);
    </script>
</body>

</html>