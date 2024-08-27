<?php 
session_start();
require 'model/function.php';

// Cek Dulu Ferguso User Sudah Dari Laman Login Belum
// Kalo Belum Tendang ae
if(!isset($_SESSION["login"])){
    header("Location: login.php");
}

$id = $_GET["id"];
// Ambil Data Sebelum Diubah Tampilkan Kepada User Agar User Tidak Binggung
// Mana Perbedaan Data Yang Sudah Diubah Dan Belum Diubah
// Fungsi Indeks Array [0] Pada Akhir Syntax Adalah Untuk Mengambil
// Data Indeks ke [0] Nanti Pada Kotak Pensil Intinya Pasti Indeks [0]
// Harus Selalu Disertakan
$hasil = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


if(isset($_POST["submit"])){
    
    // Melakukan Pengecekkan Apakah Data Berhasil Di edit Atau Tidak Kedalam
    // Database Karena Pesan Kesalahn Ketika Data Berhasil Dieditt Atau Tidak
    // Tidak Dibuatkan Oleh System
    if(edit($_POST) > 0){
        echo "
            <script>
                alert('Data Berhasil Diedit');
                document.location.href = 'display.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Data Gagal Diedit');
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
        <h1>Update Data Mahasiswa</h1>
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $hasil['id']; ?>">
        <input type="hidden" name="gambarLama" value="<?php echo $hasil['gambar']; ?>">
            <div>
            <label for="nama" class="form__label">Masukkan Nama Mahasiswa</label>

                <input type="text" name="nama" id="nama" class="form__input" required value= "<?php echo $hasil['nama'];?>" autocomplete="off">
            </div>
            <div>
                <label for="npm" class="form__label">Masukkan NPM Mahasiswa</label>
                <input type="text" name="npm" id="npm" class="form__input" required value="<?php echo $hasil['npm'];?>" autocomplete="off">
            </div>
            <div>
                <label for="email" class="form__label">Masukkan Email Mahasiswa Anda</label>
                <input type="text" name="email" id="email" class="form__input" required value="<?php echo $hasil['email'];?>" autocomplete="off">
            </div>
            <div>
                <label for="jurusan" class="form__label">Silahkan Masukkan Jurusan Mahasiswa</label>
                <input type="text" name="jurusan" id="jurusan" class="form__input" required value="<?php echo $hasil['jurusan'];?>" autocomplete="off">
            </div>
            <div>
                <label for="gambar">Gambar Mahasiswa: </label>
                <br>
                <img src="src/<?php echo $hasil['gambar'];?>" alt="">
                <br>
                <input type="file" name="gambar" id="gambar">
            </div>
            <button type="submit" name="submit">Edit Data Coy</button>
        </form>
    </div>
</body>
</html>