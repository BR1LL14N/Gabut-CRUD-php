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
    <?php $title = 'Display Data'; ?>    
    <?php require_once('header.php') ?>

</head>
<body>
    
        <!-- Awal Bagian Searching -->
         <!-- LOGIKA LIVE SEARCHING NYA ADA PADA FILE AJAX.JS PADA -->
          <!-- FILE SCRIPT -->
        <form action="" method="post" class="flex flex-row items-center gap-2">
            <input type="text" name="keyword" placeholder="Silahkan Masukkan Keyword Pencarian" autocomplete="off" size="50" autofocus id="search">
            <!-- <button type="submit" name="cari" id="tombol-search">Cari Kang</button> -->
            <img src="https://media.tenor.com/2BLI5EO7yVAAAAAi/loading-image.gif" width="20px" id="loader" class="hidden">
        </form>
        <br>
        <!-- Akhir Bagian Searching -->
        
        <!-- Awal Logout Link -->
         <!-- LOGIKA NYA BERADA PADA FILE LOGOUT.PHP YANG BERADA -->
          <!-- PADA FOLDER MODEL -->
         <a href="model/logout.php">
         <button type="submit" class="rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
            Logout kang
        </button>
         </a> <a href="./model/cetak.php" target="_blank">
            <button type="submit">Cetak</button>
         </a>
         <!-- Akhir Logout Link -->

        <!-- Awal Table Data -->
        <h1>Hasil Data Mahasiswa</h1>
        <div id="container">
            <table class="table-auto border-1 border-slate-500">
                <thead>
                    <tr class="bg-red-500">
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
                             <!-- Yang ingin dihapus menggunakan method Get -->
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
