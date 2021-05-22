<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;

}
   

// Menghubungkan ke halaman functions
	require 'functions.php';

// Memanggil fungsi query yang dimasukkan ke dalam variabel
	$alat_musik = query("SELECT * FROM alat_musik");

    if(isset($_GET['page'])){

        if ( index($_GET) > 0 ) {
            echo "<script>
                    alert('alat baru berhasil ditambahkan');
                 </script>";
     
        } else{
                echo mysqli_error($db);
        }


         // menangkap data berdasarkan id_alat
        $id_alat = $_GET["id_alat"];
        deleteAlat($id_alat);
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
    <h3>Tabel Alat Musik</h3>
    </div>
            <div class="mb-2">
                <a class="btn btn-outline-danger" href="tambah_alat.php" role="button">Tambah Data</a>
            </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th>Id Alat</th>
                            <th>Nama Alat</th>
                            <th>Gambar</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach( $alat_musik as $row ) : ?>
                        <tr>
                            <td><?= $row["id_alat"] ?></td>
                            <td><?= $row["nama_alat"] ?></td>
                            <td><img src="img/<?= $row["gambar"]; ?>"width="100"></td>
                            <td><?= $row["harga"] ?></td>
                            <td><?= $row["stok"] ?></td>
                            <td>
                                <a href="index.php?page=&id_alat=<?= $row["id_alat"]; ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>   
    </section>

  </body>
</html>