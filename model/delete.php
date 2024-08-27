<?php
session_start();
require 'function.php';

// Cek Dulu Ferguso User Sudah Dari Laman Login Belum
// Kalo Belum Tendang ae
if(!isset($_SESSION["login"])){
    header("Location: login.php");
}

$id = $_GET["id"];

if(delete($id) > 0){
    echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href = '../display.php';
            </script>
        ";
}else{
    echo "
            <script>
                alert('Data Gagal Dihapus');
                document.location.href = '../display.php';
            </script>
        ";
}

?>