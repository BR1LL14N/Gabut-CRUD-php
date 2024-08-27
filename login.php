<?php 
session_start();
require 'model/function.php';

    // Cek Apakah Cookie Sudah Pernah Di Set Atau Belum
    if(isset($_COOKIE['togel']) && isset($_COOKIE['kodenuklir'])){

        // Simpan Tiap Tiap Cookie Di Variabel Bebas
        $id = $_COOKIE['togel'];
        $username = $_COOKIE['kodenuklir'];

        // Cari Username Berdasarkan id Yang Sudah Dikirimkan Lewat Cookie
        $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");

        // Tangkap Data nya
        $row = mysqli_fetch_assoc($result);

            // Kemudian Cocokan Username Yang Sudah Di hash Dengan
            // Username User Yang Buaru Banget Di hash
            if($username === hash('sha256', $row['username'])){
                
                // Kalo Semua Benar Bisa Set Session nya
                $_SESSION["login"] = true;
            }
        
    }

    // Kemudian Cek Lagi Apakah "$_SESSION["login"]" Sudah Pernah
    // Dibuat Jika Pernah Maka Langsung Lempar Ke Display.php
    if(isset($_SESSION["login"])){

        header("Location: display.php");
                exit;
    }

    if(isset($_POST["login"])){
        // Seperti Biasa Tangkap Semua Data Yang Diinputkan Oleh User
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Cari Pada Tabel users Apakah Username nya Ada Atau Tidak
        // NOTE TIDAK BISA MENGGUNAKAN FUNCTION query() YANG ADA PADA FILE FUNCTION
        // KARENA NILAI YANG DIKEMBALIKAN ADALAH ARRAY SEDAGKAN SAYA HANYA BUTUH BARIS YANG
        // TERPENGARUH
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        // JIka Username Ketemu
        // Kenapa Kok Sama Dengan Satu Karena Jika Data
        // Ditemukan MAka Nilai Yang Dikembalikan Adalah 1 Yang Berarti true
        if(mysqli_num_rows($result) === 1){
            // Ambil Value Yang Ada Pada $result
            $row = mysqli_fetch_assoc($result);

            // Cocokan Password Dari Database Yang Sudah Di Hash Dengan
            // Syntax "password_verify()" Yang Membandingkan 
            // Password User Yang Diinputkan 
            // Dengan Yang Tersimpan 
            //  Di Database JIka Benar Redirect User Ke
            // Laman display
            if(password_verify($password,$row["password"])){
                // Berikan Session Dulu Sebagai Acuan Untuk
                // Mengecek Apakah USer Sudah Melakukan Login Atau Belum
                $_SESSION["login"] = true;

                // Percobaan Set Cookie Jika Check box nya di Chechlist
                if(isset($_POST['remember'])){

                    // Buat 2 Cookie satu untuk Mengambil id Dan satu nya
                    // Untuk Mengambil Username Yang Sesuai dengan id Namun
                    // Di hash, Syntax "hash()" Adalah Syntax Bawaan Php Yang Digunakan
                    // Untuk Enkripsi Data Agar Tidak Terbaca User Jahat
                    // Untuk Kasus Kali Ini Kode Pengacakkan Yang Digunakan Adalah
                    // sha256 
                    setcookie('togel',$row['id'], time()+86400 , '/');
                    setcookie('kodenuklir', hash('sha256', $row['username']), time()+86400 , '/');
                }

                // Baru Ditendang Ke Halaman Display
                header("Location: display.php");
                exit;
            }

        }
        $error = true;
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laman Login</title>
</head>
<body>
    <h2>Selamat Datang Di Laman Login</h2>
    <form action="" method="post">

        <ul>
            <li>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" autocomplete="off">
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" autocomplete="off">
            </li>
        </ul>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
       
        <br>
        <br>

        <!-- Pesan Kesalahan Error Apabila User Gagal Login -->
        <?php if(isset($error)) :?>
            <p>Username / Password Salah</p>
            <?php endif;?>
        
        <button type="submit" name="login">Login Kang</button>
        <br>
    </form>
    <a href="register.php">
        <button type="submit">Register</button>
    </a>
</body>
</html>