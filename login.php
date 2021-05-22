<?php 

session_start();

if( isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;

}

require 'functions.php';

if( isset($_POST["login"]) ) {

    $username = $_POST["username"];
    $password = $_POST["password"];

   $result = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'");

    //cek username
    if( mysqli_num_rows($result) === 1 ) {

        //cek password

        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"]) ){

            //set session
            $_SESSION["login"] = true;

            header("Location: index.php");
            exit;

        }
    }

    $error = true;


}

?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {

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

img.avatar {
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

<h2>Login Form</h2>
<center>
<form action="" method="post">
  <div class="imgcontainer">
    <img src="avatar.jpg" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="username"><b>Username     :</b></label>
    <input type="text" placeholder="Username" name="username" required>

    <label for="passsword"><b>Password    :</b></label>
    <input type="password" placeholder="Password" name="password" required>
        
    <button type="submit" name="login">Login</button>
   
  </div>
<div>
<span class="reg">don't have an account ? <a href="registrasi.php">signup</a></span>

</div>

</form>
</center>
</body>
</html>

