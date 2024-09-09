<?php 
require '../model/function.php';


// Semua Data Yang diamnil dari file ajax.js ada disini
// Namun Sebelum Diambil harus diolah dulu Ngolah nya sama
// Logika nya seperti di function search pada file function.php

$keyword = $_GET['keyword'];
$query = "SELECT * FROM mahasiswa
            WHERE nama LIKE '%$keyword%' OR
            npm LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'";

$mahasiswa = query($query);

?>

            <table  class="table-auto border-1 border-slate-500">
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