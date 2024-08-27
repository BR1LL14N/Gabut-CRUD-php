<?php 
require 'model/function.php';

// Seperti Biasa Pop Up Jika Registrasi User Berhasil 
if(isset($_POST["register"])){

    if(register($_POST) > 0){
        echo "<script>
            alert('User Baru Berhasil Ditambahkan');
            </script>
        ";
    }else{
        echo "<script>
            alert('Register Gagal');
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
    <title>Halaman Registrasi</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>
    <h2>Silahkan Kengkapi Data Anda Dibawah Ini</h2>
    <form action="" method="post">
        <ul>
            <li>
                <label for="uesrname">Esername: </label>
                <input type="text" name="username" id="username" autocomplete="off" required>
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" autocomplete="off" required>
            </li>
            <li>
                <label for="password2">Silahkan Masukkan Ulang Konfirmasi Password Anda: </label>
                <input type="password" name="password2" id="password2" autocomplete="off" required>
            </li>
        </ul>
        <button type="submit">Register</button>
    </form>
    <a href="login.php">
        <button type="submit">Login</button>
    </a>
   
</body>
</html>