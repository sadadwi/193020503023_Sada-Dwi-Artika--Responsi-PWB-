<?php


	// Menghubungkan ke halaman functions
    require 'functions.php';

    // cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {

    // cek apakah data berhasil ditambahkan atau tidak
    insertAlat($_POST);
    echo "<script>
        alert('Alat Musik  baru berhasil ditambahkan');
     </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Tambah Data Alat</title>
</head>
<body> 
    <h3>Tambah Data Alat Musik</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama_alat">Nama Alat</label>
                    <input type="input" name="nama_alat" id="nama_alat" required>
                </div>
                <div>
                    <label for="gambar">Gambar</label>
                    <input type="input" name="gambar" id="gambar" required>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="input" name="harga" id="harga" required>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="input" name="stok" id="stok" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="submit" >Submit</button>
                    
                </div>
            </form>
        </div>
    </section>  
</body>
</html>