<?php 
session_start();
require 'model/function.php';

// Cek Dulu Ferguso User Sudah Dari Laman Login Belum
// Kalo Belum Tendang ae
if(!isset($_SESSION["login"])){
    header("Location: login.php");
}

if(isset($_POST["submit"])){

    
    // Melakukan Pengecekkan Apakah Data Berhasil Masuk Atau Tidak Kedalam
    // Database Karena Pesan Kesalahn Ketika Data Berhasil Masuk Atau Tidak
    // Tidak Dibuatkan Oleh System serta mengirimkan semua elemen atau
    // Data berada pada $_POST yang berada pada laman ini
    if(adddata($_POST) > 0){
        echo "
            <script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'display.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'display.php';
            </script>
            ";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/adddata.css"> -->
    <title>Add Data Bang</title>
</head>
<body>
    <div class="container">
        <h1>Silahkan Lengkapi Data Anda Dibawah Ini Untuk Menambah Data</h1>
        <!-- Fungsi syntax "enctype" Adalah Untuk Menghandle File Gambar Yang Dikirm Oleh User -->
        <form action="" method="post" enctype="multipart/form-data">
            <div>
            <label for="nama" class="form__label">Masukkan Nama Mahasiswa</label>

                <input type="text" name="nama" id="nama" required autocomplete="off">
            </div>
            <br>
            <div>
                <label for="npm" class="form__label">Masukkan NPM Mahasiswa</label>
                <input type="text" name="npm" id="npm" required autocomplete="off">
            </div>
            <br>
            <div>
                <label for="email" class="form__label">Masukkan Email Mahasiswa Anda</label>
                <input type="text" name="email" id="email" required autocomplete="off">
            </div>
            <br>
            <div>
                <label for="jurusan" class="form__label">Silahkan Masukkan Jurusan Mahasiswa</label>
                <input type="text" name="jurusan" id="jurusan" required autocomplete="off">
            </div>
            <br>
            <div>
                <label for="gambar" class="form__label">Masukkan Gambar Mahasiswa Anda</label>
                <input type="file" name="gambar" id="gambar">
            </div>
            <br>
            <button type="submit" name="submit">Tambah Data Coy</button>
        </form>
    </div>
</body>
</html>
