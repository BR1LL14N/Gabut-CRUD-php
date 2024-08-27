<?php 
session_start();

// Cek Dulu Ferguso User Sudah Dari Laman Login Belum
// Kalo Belum Tendang ae
if(!isset($_SESSION["login"])){
    header("Location: login.php");
}

require 'model/function.php';
// Gunakan Syntax Bawaan MYSQL nya untuk mengambil semua data pada tabel mahasiswa
$mahasiswa = query("SELECT * FROM mahasiswa");

// Jika user menggunakan tombol cari
// Tapi berhubung saya sudah menggunakan live searching
// jadi tidak guna syntax ini
if(isset($_POST["cari"])){
    $mahasiswa = search($_POST["keyword"]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .loader{
            width: 110px;
            position: absolute;
            top: -23px;
            z-index: -1;
            display: none;
        }
    </style>
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <title>Ngetes SQL</title>
</head>
<body>
    
        <!-- Awal Bagian Searching -->
         <!-- LOGIKA LIVE SEARCHING NYA ADA PADA FILE AJAX.JS PADA -->
          <!-- FILE SCRIPT -->
        <form action="" method="post">
            <input type="text" name="keyword" placeholder="Silahkan Masukkan Keyword Pencarian" autocomplete="off" size="50" autofocus id="search">
            <button type="submit" name="cari" id="tombol-search">Cari Kang</button>
            <img src="src/loader.gif" class="loader">
        </form>
        <br>
        <!-- Akhir Bagian Searching -->
        
        <!-- Awal Logout Link -->
         <!-- LOGIKA NYA BERADA PADA FILE LOGOUT.PHP YANG BERADA -->
          <!-- PADA FOLDER MODEL -->
         <a href="model/logout.php">
            <button type="submit">Logout kang</button>
         </a> <a href="./model/cetak.php" target="_blank">
            <button type="submit">Cetak</button>
         </a>
         <!-- Akhir Logout Link -->

        <!-- Awal Table Data -->
        <h1>Hasil Data Mahasiswa</h1>
        <div id="container">
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Action</th>
                        <th>Gambar</th>
                        <th>Nama Mahasiswa</th>
                        <th>NPM Mahasiswa</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($mahasiswa as $row) : ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td class="action-links">
                            <!-- Pada bagian edit maupun delete mengirmkan id user -->
                             <!-- Yang ingin yang dihapus menggunakan method Get -->
                              <!-- Karena nanti dibuat Acuan PAda Bagian Logikanya -->
                            <a href="edit.php?id=<?php echo $row["id"];?>">Edit</a>
                            <a href="model/delete.php?id=<?php echo $row["id"]; ?>" class="delete" onclick="return confirm('Yakin?');">Delete</a>
                        </td>
                        <td><img src="src/<?php echo $row["gambar"]; ?>" alt=""></td>
                        <td><?php echo $row["nama"]; ?></td>
                        <td><?php echo $row["npm"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["jurusan"]; ?></td>
                        <?php $no++; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
            <!-- Akhir BAgian Table Data -->
            <br>
            <div class="add-data">
                <a href="adddata.php">
                    <button type="submit">Add Data</button>
                </a>
            </div>
                        

    <script src="script/jquery-3.7.1.min.js"></script>
    <script src="script/ajax.js"></script>
</body>
</html>
