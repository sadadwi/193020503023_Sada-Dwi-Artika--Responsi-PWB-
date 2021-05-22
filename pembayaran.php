<?php 
// Menghubungkan ke halaman functions
	require 'functions.php';

// Memanggil fungsi query yang dimasukkan ke dalam variabel
    $pembayaran = query("SELECT * FROM pembayaran");

    if(isset($_GET['page'])){

        if ( deletePembayaran($_GET) > 0 ) {
            echo "<script>
                    alert('delete berhasil');
                    document.location.href = 'pembayaran.php';
                 </script>";
     
        } else{
            echo "<script>
            alert('delete gagal');
            document.location.href = 'pembayaran.php';
         </script>";
        }

       deletePembayaran($_GET);
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
            <h3>Tabel Pembayaran</h3>
            </div>
        <div class="mb-2">
                <a class="btn btn-outline-danger" href="tambah_pembayaran.php" role="button">Tambah Data</a>
        </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th>No Order</th>
                            <th>Tanggal</th>
                            <th>Id Pembeli</th>
                            <th>Total Beli</th>
                            <th>Bayar</th>
                            <th>Sisa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach( $pembayaran as $row ) : ?>
                            <tr>
                                <td><?= $row["no_order"] ?></td>
                                <td><?= $row["tanggal"] ?></td>
                                <td><?= $row["id_pembeli"] ?></td>
                                <td><?= $row["total_beli"] ?></td>
                                <td><?= $row["bayar"] ?></td>
                                <td><?= $row["sisa"] ?></td>
                                <td>
                                    <a href="pembayaran.php?page=&no_order=<?= $row["no_order"]; ?>&tanggal=<?= $row["tanggal"];?>">Hapus</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
    </section>

  
  </body>
</html>