<?php 


// Menghubungkan ke halaman functions
	require 'functions.php';

// Memanggil fungsi query yang dimasukkan ke dalam variabel
	$pembeli = query("SELECT * FROM pembeli");

    if(isset($_GET['page'])){


        if ( pembeli($_GET) > 0 ) {
            echo "<script>
                    alert('pembeli baru berhasil ditambahkan');
                 </script>";
     
        } else{
                echo mysqli_error($db);
        }

     
        
// menangkap data berdasarkan id_pembeli
        $id_pembeli = $_GET["id_pembeli"];
        deletePembeli($id_pembeli);
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>RESPONSI PEMWEB</title>
  </head>
  <body>

  <!-- button log out -->
  <button ><a href="logout.php">logout</a></button>


  <section>
        <div class="row">
        <div class="col">
        <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #ed7b64;" >
        <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Tabel Alat Musik <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                     <a class="nav-link" href="pembeli.php">Table Pembeli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pembayaran.php">Tabel Pembayaran</a>
                </li>
            </ul>
        </div>
        </div> 
        </nav>
        </div>
        </div>
	</section>
      
    <section class="mt-3 pl-5 pr-5">
        <div class="pb-4">
            <h3>Tabel Pembeli</h3>
        </div>
        <div class="mb-2">
                <a class="btn btn-outline-danger" href="tambah_pembeli.php" role="button">Tambah Data</a>
        </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th>Id Pembeli</th>
                            <th>Id Alat</th>
                            <th>Jumlah Beli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach( $pembeli as $row ) : ?>
                        <tr>
                            <td><?= $row["id_pembeli"] ?></td>
                            <td><?= $row["id_alat"] ?></td>
                            <td><?= $row["jumlah_beli"] ?></td>
                            <td>
                                <a href="pembeli.php?page=&id_pembeli=<?= $row["id_pembeli"]; ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
    </section>


  </body>
</html>