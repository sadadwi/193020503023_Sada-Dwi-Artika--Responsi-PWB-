<?php 

require 'functions.php';

if( isset($_POST["register"])) {

   if ( registrasi($_POST) > 0 ) {
   	echo "<script>
   			alert('user baru berhasil ditambahkan');
			</script>";

   } else{
   		echo mysqli_error($db);
   }
}


 ?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password], input[type=password2] {

  width: 300px;
  padding: 12px 20px;
  margin: 8px auto;
  display: block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  
}

button {

  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 10%;
}



.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.pp {
  width: 10%;
  border-radius: 20%;
}

.container {
  padding: 16px;
}

span.reg {
  float: center;
  padding-top: 16px;
}
</style>
</head>
<body>

<h2>Halaman Registrasi</h2>
<center>
<form action="" method="post">
  <div class="imgcontainer">
    <img src="pp.png" alt="pp" class="pp">
  </div>

  <div class="container">
    <label for="username"><b>Username     :</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="passsword"><b>Password    :</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

	<label for="passsword2"><b> Confirm Password    :</b></label>
    <input type="password2" placeholder="Enter Password" name="password2" required>
        
    <button type="submit" name="register">Submit</button>
   
  </div>

  <div>
<span class="reg">have an account ? <a href="login.php">login</a></span>

</div>

</form>
</center>
</body>
</html>
