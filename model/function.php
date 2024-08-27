<?php 

// Connect kan Dengan Database (Ada 4 Parameter host,username,pass,nama database)
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($tujuan){
    global $conn;
    // Mengambil Data Dari Tabel Mahasiswa (Database akan Mengembalikan 2 nilai default 1 data dari table dan bernilai boolean)
    $result = mysqli_query($conn, $tujuan);
    $rows = [];

    // Ada Beberapa Syntax Untuk Menangkap Dan Mengambil Data (fetch) Dari Database
    // mysqli_fetch_row() => Mengambil Data Dari Database Dan Dijadikan Ke Bentuk Array Numerik 
    // mysqli_fetch_assoc() => Mengambil Data Dari Databse Dan Dijadikan Ke Bentuk Array Assosiatif
    // mysqli_fetch_array() => Hybrid Bisa Numerik Bisa Assosiatif Namun Data Yang Dicetak Akan Ganda
    // mysqli_fetch_object() => Mengambil Data Dari Database Dan Dijadikan Ke Bentuk Object
    while($row = mysqli_fetch_assoc($result)){
        // Menggunakan Metode ini dapat mebuat source code lebih clean dan efektif
        // Jika ingin mengdebug
        $rows[] = $row;
    }
    return $rows;

}



function adddata($data){
    global $conn;
    // Usahakan Pisahkan Setiap Elemen Kedalam Variabel Yang Berbeda Beda
    // Untuk Meminimalisir Kebingungan Ketika Akan Menginputkan Data Pada Database

    $nama = htmlspecialchars($data["nama"]);
    $npm = htmlspecialchars($data["npm"]);
    // Gunakan syntax "htmlspecialchars" untuk menghindari user jahat
    // Yang akan Menyisipkan Sebuah syntax Kedalam Sebuah Form 
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambar = uploadimg();

    if(!$gambar){
        return false;
    }

    // Syntax insert SQL nya Saya Jadikan dalam Variabel query
    $query = "INSERT INTO mahasiswa VALUES 
    ('', '$nama', '$npm', '$email', '$jurusan', '$gambar')";

    // Kemudian Masukkan Ke Dalam Database
    mysqli_query($conn,$query);

    // Kembalikan Nilai Affected Rows nya Untuk
    // Dijadikan Acuan Pengecakkan Apakah Data Berhasil Masuk Kedalam
    // Database Atau Tidak
    return mysqli_affected_rows($conn);

}


function uploadimg(){
    // Ambil Semua Elemen Yang Diperlukan Dari $_FILES Kemudian Simpan Dalam Variabel Yang Berbeda 
    // Petik Yang Digunkan Merupakan Petik 1 ' '
    $namafile = $_FILES['gambar']['name'];
    $ukuran = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpimg = $_FILES['gambar']['tmp_name'];
    
    // Pengeecakan Apakah User Sudah Memasukkan Gambar Atau Tidak
    // Angka 4 Merupakan Pesan Error yang Ditampilkan Dalam $_FILES Jika User Tidak
    // Meng-upload File Sama Sekali (Ada Banyak Aslinya Pesan Error Yang Lainnya Cuma Ini Yang Basic Basic Ae)   
    if($error === 4){
        echo "<script>
            alert('Silahkan Upload Gambar Terlebih Dahulu');
                </script>";
        return false;
    }

    // Pengecakan Apakah File Yang Upload Oleh User
    // Merupakan File Gambar
    $kategoriIMGvalid = ['jpg', 'jpeg', 'png'];

    // Fungsi Syntax "explode" Adalah Untuk Memecah String Dengan Patokan
    // Yang Sudah Ditentukan Menjadi Array numerik
    $ekstensiGambar = explode('.', $namafile);

    // Fungsi sybtax "strtolower" Adalah Untuk Mebuat Semua String Menjadi
    // Huruf Kecil Semua Tanpa Kapital Dan Fungsi syntax "end"
    // Adalah Untuk Mengambil Array Terakhir Dari String Yang Sudah Di explode
    // Sebelumnya
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // Syntax "in_array()" Bertugas Untuk Mencocokan Apakah Ekstensi Gambar Yang User
    // Inoutkan Diizinkan Oleh Sistem Atau Tidak Yang Dimana 
    // Kualiasi Standarisasi Nya Sudah Dibuat Di Array "$latgoriIMGvalid"
    // Jadi Kayak Di loop Semua Dan Dicocokkan
    if(!in_array($ekstensiGambar,$kategoriIMGvalid)){
        echo "<script>
                alert('File Yang Anda Upload Bukan Gambar');
                </script>";
        return false;
    }

    // Pengecekkan Size Gambar Apakh Terlalu Besar Atau Tidak
    // Satuan Menggunakan Satuan Byte Jadi 1 juta byte sama dengan
    // 1 MB
    if($ukuran > 1000000){
        echo "
            <script>
            alert('Ukuran File Gambar Yang Anda Masukkan Terlalu Besar MAX 1 MB');
            </script>";
        return false;
    }

    // JIka Lolos Semua Seleksi Diatas
    // Buat Nama Random Menggunakan syntax "uniqid()"
    // Untuk Mengatsi Ada Nama File Yang Sama Di Dalam DataBase
    $namaFilebaru = uniqid();
    // Kemudian Rangkai Kalimat File Nya dengan Ekstensi Yang Sudah Di cek Sebelumnya
    $namaFilebaru .= '.';
    $namaFilebaru .= $ekstensiGambar;
    // Upload Imge Yang Sudah Lolos Semua Tahap Pengecekan
    move_uploaded_file($tmpimg,'src/' . $namaFilebaru);

    return $namaFilebaru;
}


function delete($id){
    global $conn;
    // Syntax Delete MySQL Adalah Seperti Dibawah Ini Namun Acuan Hapus
    // nya Adalah id Anda Bisa Mengubah Acuan Nya Tergantung Pada Primary
    // Key Apa Yang Jadikan Acuan
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    // Mengembalikan Pesan Berhasil Atau Tidak
    return mysqli_affected_rows($conn);
}


function edit($data){
    global $conn;
    // Usahakan Pisahkan Setiap Elemen Kedalam Variabel Yang Berbeda Beda
    // Untuk Meminimalisir Kebingungan Ketika Akan Menginputkan Data Pada Database

    $id = $data["id"];
    // Cek apakah id memiliki nilai dan tidak kosong
    if (empty($id)) {
        throw new Exception("ID tidak ditemukan.");
    }
    $nama = htmlspecialchars($data["nama"]);
    $npm = htmlspecialchars($data["npm"]);

    // Gunakan syntax "htmlspecialchars" untuk menghindari user jahat
    // Yang akan Menyisipkan Sebuah syntax Kedalam Sebuah Form 
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    // Cek Apakah User Meng-Update Gambar Baru Atau Tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = uploadimg();
    }
    
    

    // Syntax Update SQL nya Saya Jadikan dalam Variabel query
    $query = "UPDATE mahasiswa SET
            nama = '$nama',
            npm = '$npm',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar'

            WHERE id = $id ";



    // Kemudian Masukkan Ke Dalam Database
    mysqli_query($conn, $query);

    // Kembalikan Nilai Affected Rows nya Untuk
    // Dijadikan Acuan Pengecakkan Apakah Data Berhasil Masuk Kedalam
    // Database Atau Tidak
    return mysqli_affected_rows($conn);
}


function search($keyword){

    // Fungsi Pencarian Yang Menggunakan Syntax Bawaan mySQL Kemudian 
    // Penggunaan "LIKE" Untuk Mencari Hasil Relavan Terhadap
    // Keyword Yang Diinputan User Jadi Semisal Yang Diinputkan
    // User Kata Kuncinya Mendekati Value Yang Ada Di Dalam Dalam Maka
    // Akan Tampil Hasil Yang Relavan Kemudian "OR" Untuk Memudahan
    // User Ingin Mencari Berdasarkan Field Mana
    $query = "SELECT * FROM mahasiswa
            WHERE nama LIKE '%$keyword%' OR
            npm LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'";
    
    // Penggunaan Function Query Disini Untuk Membuat Hasil
    // Yang Dikirim Ke disp;ay Menjadi Array Assosiatif
    return query($query);
}

function register($data){
    global $conn;

    // Fungsi "strtolower" Seperti Biasa Membuat Semua Inputan String Dari User
    // Menjadi Huruf Kecil Dan "stripslashes" Untuk Membersihkan Backslash (/) yang Diinputkan 
    // User (Entahlah Kenapa Database Tidak Menerima Backslash Atau Tidak)
    $username = strtolower(stripslashes($_POST["username"]));

    // Fungsi Syntax "mysqli_real_escape_string()" Adalah Untuk Memungkinkan
    // User Untuk Menginputkan Charakter Charater Khusus
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $password2 = mysqli_real_escape_string($conn, $_POST["password2"]);

    // Cek Apakah Usename Yang Akan Terdaftar Sudah Ada Dalam Database
    // Atau Belum
    $result = mysqli_query($conn,"SELECT username FROM users WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
            alert('Username Yang Anda Masukkan Sudah Terdaftar');
            </script>
            ";
        return false;
    }

    // Cek Apakah Konfirmasi Password Yang Diinputkan Oleh User Sudah Benar Atau Tidak
    if($password2 !== $password){
        echo "<script>
            alert('Konfirmasi Password Yang Anda Masukkan Tidak Valid Silahkan Cek Kembali');
            </script>
        ";
        return false;

    }

    // Enkripsi Password Dulu Menggunkan Syntax "password_hash" Ada Lagi Syntax "md5"
    // Namun "md5" Gampang Dibobol Fungsi Syntax nya Adalah Mengacak PAssword Asli Agar
    // Ketika Masuk Ke Database Hanya Charater Random
    $password = password_hash($password, PASSWORD_DEFAULT);


    // JIka Semua Pengecekkan Berhasil Dilalui Tinggal Masukkan Dalam Database
    $query = "INSERT INTO users VALUES(
            '', '$username', '$password'
    )";

    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

?>