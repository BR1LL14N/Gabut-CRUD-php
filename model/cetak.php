<?php 

require_once __DIR__ . '/../vendor/autoload.php';
require './function.php';
// Gunakan Syntax Bawaan MYSQL nya untuk mengambil semua data pada tabel mahasiswa
$mahasiswa = query("SELECT * FROM mahasiswa");

// Function bawaan framework mpdf nya 
// Untuk mnecetak tampilan display menjadi pdf
$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: 50px;
        }
        .action-links a {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>Daftar Mahasiswa</h1>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Gambar</th>
                <th>Nama Mahasiswa</th>
                <th>NPM Mahasiswa</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <tbody>';

// Menambahkan data dari tabel mahasiswa ke dalam HTML
$no = 1;
foreach($mahasiswa as $row) {
    $html .= '<tr>
                <td>' . $no . '</td>
                <td><img src="../src/' . $row["gambar"] . '" alt=""></td>
                <td>' . $row["nama"] . '</td>
                <td>' . $row["npm"] . '</td>
                <td>' . $row["email"] . '</td>
                <td>' . $row["jurusan"] . '</td>
              </tr>';
    $no++;
}

$html .= '</tbody>
    </table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Daftar-Mahasiswa.pdf', 'I');

?>

