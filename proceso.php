<?php

session_start();


$usuario = $_POST['usuario'];
$password = $_POST['password'];

include("index.php")

$proceso = $conect->query("SELECT * FROM user WHERE nick ='$usuario' and password ='$password' "):

  if ($resultado = mysqli_fetch_array($proceso)) {
      $_SESSION['u_usuario'] = $usuario;
    //  header("Location: sesion.php");
    echo "usuario: ".$usuario." y contraseña: ".$password;
  }else{
    //header("Location: index.php");
    print_r("sesion fea");
  }
