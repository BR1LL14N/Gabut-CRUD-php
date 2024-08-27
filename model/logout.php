<?php 
// Aslinya Lord Sandika Tidak Mengajarkan syntax ini Namun
// Saya Terkendala Dengan Cookie Saya Yang Enggan Terhapus Dan
// Ternyata Cuma Kurang Parameter
ob_start();

// Pastikan Session Benar Benar Bersih Sebelum Logout
session_start();

// Cek Cookie Untuk Membersihkan Semua Cookie Yang Sudah
// Dibuat
if (isset($_COOKIE['togel'])) {
    setcookie('togel', '', time() - 3600, '/');
}
if (isset($_COOKIE['kodenuklir'])) {
    setcookie('kodenuklir', '', time() - 3600, '/');
}

session_unset();
session_destroy();


// Baru Tendang
header("Location: ../login.php");
ob_end_flush();
exit;

?>