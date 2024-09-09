const toggle = () => {
    $('#loader').toggle('hidden');
}

$(document).ready(function(){
    // Handler Event Keyup Pada Searching

    // $('#tombol-search').hide();

    // Menangkap semua sesuatu yang dituliskan user pada field searching
    // Kemudian mengolahknya 
    $('#search').on('keyup', function(){

        // Memnuculkan Gimmick Loading

        // Mengambil data yang sudah diolah dari mahasiwa.php
        // Dan mengirim keyword serta menampilkan nya Mirip inner.html
        // $('#container').load('script/mahasiswa.php?keyword=' + $('#search').val());
        const search = $('#search').val();

        if (search.length >= 1 && search.length <= 3) return;
        console.log(search.length)
        toggle();

        
        // Cara Kedua Untuk mengtasai Masalah pada Gimmick Loading Yang
        // Tidak Bisa Hilang Setelah Data Tampil Menggunakan Syntax $.get
        // Sam Ae Aslinya Cuma Sekarang hasilnya Disimpan Di Parameter data
        $.get('script/mahasiswa.php?keyword=' + search, function(data){
            // Kemudain Ganti Isi Container nya Dan Tampilkan
        // Sama Kek inner.html 
        $('#container').html(data);

        // Jadi Setelah Data Tampil Loader Nya Bisa Di hide Lagi
        toggle();
        });


    });
});