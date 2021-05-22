<?php


// Menghubungkan ke halaman functions
    require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {

// cek apakah data berhasil ditambahkan atau tidak
        insertPembayaran($_POST);
        echo "<script>
        alert('data pembayaran baru berhasil ditambahkan');
     </script>";
    }

    $data = query("SELECT * FROM pembeli GROUP BY id_pembeli");
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
    <h3>Tambah Data Pembayaran</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" required>
                </div>
                <div>
                    <label for="id_pembeli">Id Pembeli</label>
    
                    <select id="id_pembeli"  name="id_pembeli">
                     <!-- untuk memilih id agar otomatis terpilih (id yg auto incr)-->
                    <option selected>Choose</option>
                    <?php
                    foreach ($data as $d) {
                    ?>
                        <option>
                            <?php echo $d["id_pembeli"]; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                </div>
                <div>
                    <label for="bayar">Bayar</label>
                    <input type="input" name="bayar" id="bayar"required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </section>  
</body>
</html>