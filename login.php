<?php
    include "cfg.php";

    $user = $_POST['usuario'];
    $pass = $_POST['senha'];

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$user}' AND senha = '{$pass}'") or die (mysql_error());

    $dado = mysql_fetch_array($sql);
    $resultado = mysqli_num_rows($sql);

    if(resultado == 0){
        echo 0;
    } else {
        echo 1;
        if(!isset($_SESSION)){
            session_start;
            $_SESSION['id'] = $dado['id'];
            $_SESSION['usuario'] = $dado['usuario'];
            $_SESSION['nivel'] = $dado['nivel'];
            exit;
        }
    } 
?>