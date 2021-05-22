<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "toko_alat_musik";
    $db = mysqli_connect($servername, $username, $password, $dbname);

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

function query($query){
	global $db;
	$result = mysqli_query($db, $query);
	$rows = [];

	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}

	return $rows;
}


function deleteAlat($id_alat){
	global $db;
	mysqli_query($db, "CALL Delete_Alat_Musik('$id_alat')");
	
	// cek apakah data berhasil dihapuskan atau tidak
	return mysqli_affected_rows($db);	
}

function deletePembeli($id_pembeli){
	global $db;
	mysqli_query($db, "CALL Delete_Pembeli('$id_pembeli')");
	
	// cek apakah data berhasil dihapuskan atau tidak
	return mysqli_affected_rows($db);	
}


function deletePembayaran($data){
	global $db;
	$no_order = $data["no_order"];
    $tanggal = $data["tanggal"];
    $no = substr($no_order, 7, 2);

	mysqli_query($db, "CALL Delete_pembayaran('$no', '$tanggal')");
	
	// cek apakah data berhasil dihapuskan atau tidak
	return mysqli_affected_rows($db);	
}

function insertAlat($data) {
	global $db;
	
	$nama_alat = htmlspecialchars($data["nama_alat"]);
	$gambar = htmlspecialchars($data["gambar"]);
	$harga = htmlspecialchars($data["harga"]);
	$stok = htmlspecialchars($data["stok"]);


	 // query insert data
	$query = "CALL insert_alat_musik ('$nama_alat', '$gambar', '$harga', '$stok')";
	mysqli_query($db, $query);

	// cek apakah data berhasil ditambahkan atau tidak
	return mysqli_affected_rows($db);
}

function insertPembeli($data) {
	global $db;

	$id_alat = htmlspecialchars($data["id_alat"]);
	$jumlah_beli = htmlspecialchars($data["jumlah_beli"]);

	$query = "CALL insert_pembeli ('$id_alat', '$jumlah_beli')";
	mysqli_query($db, $query);

	// cek apakah data berhasil ditambahkan atau tidak
	return mysqli_affected_rows($db);
}

function insertPembayaran($data) {
	global $db;
	
	$tanggal = htmlspecialchars($data["tanggal"]);
	$id_pembeli = htmlspecialchars($data["id_pembeli"]);
	$bayar = htmlspecialchars($data["bayar"]);

	$cek = mysqli_query($db, "SELECT id_pembeli FROM pembayaran WHERE id_pembeli = '$id_pembeli'");
    if (mysqli_fetch_assoc($cek)) {
        echo "
        <script>
            alert('id detail sudah ada');
            document.location.href = 'index.php?page=pembayaran&act=home';
        </script>
        ";
        return false;
    } else{
		$query = "CALL insert_pembayaran('$tanggal', '$id_pembeli', '$bayar')";
		mysqli_query($db, $query);

		// cek apakah data berhasil ditambahkan atau tidak
		return mysqli_affected_rows($db);
    }
}

// registrasi
function registrasi($data){
	global $db;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($db, $data["password"]);
	$password2 = mysqli_real_escape_string($db, $data["password2"]);

// cekusername sudah ada atau belum

$result = mysqli_query($db, "SELECT username FROM users WHERE username = '$username'");
if(mysqli_fetch_assoc($result)){
echo "<script>

	alert('username sudah terdaftar');
</script>";
return false;


}
	//cek confirm password
	if( $password !== $password2 ){
		echo "<script>
				alert('konfirmasi password tidak sesuai');
		
		</script>";
		return false;
	}

// enkripsi password
$password = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($db, "INSERT INTO users VALUES('', '$username', '$password')");

return mysqli_affected_rows($db);


}
?>