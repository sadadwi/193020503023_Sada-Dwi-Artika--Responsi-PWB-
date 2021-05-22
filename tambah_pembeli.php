<?php

// Menghubungkan ke halaman functions
    require 'functions.php';
 
// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        
// cek apakah data berhasil ditambahkan atau tidak
        insertPembeli($_POST);
        echo "<script>
        alert('data pembeli baru berhasil ditambahkan');
     </script>";

    }

    $data = query("SELECT * FROM alat_musik GROUP BY id_alat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Tambah Data</title>
</head>
<body> 

    <h3>Tambah Data Pembeli</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="id_alat">Id Alat</label>
                    <!-- <input type="input" name="id_alat" id="id_alat" required> -->
                    <select id="id_alat"  name="id_alat">
                    <option selected>Choose</option>
                    <?php
                    foreach ($data as $d) {
                    ?>
                        <option>
                            <?php echo $d["id_alat"]; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                </div>
                <div>
                    <label for="jumlah_beli">Jumlah Beli</label>
                    <input type="input" name="jumlah_beli" id="jumlah_beli" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </section>  
</body>
</html>