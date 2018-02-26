<?php
    session_start();

    include "cfg.php";

    $funcao = 0;
    $funcao = $_POST['executarFuncao'];
    

    $resultado = 0;

    if($funcao == 1){
        $user = $_SESSION['usuario'];
        $pass = $_SESSION['senha'];

        $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$user}' AND senha = '{$pass}'") or die (mysql_error());

        $dado = mysqli_fetch_array($sql);
        $resultado = $dado['nivel'];
    }

    if($funcao == 2){
        $r_usuario = $_POST['r_usuario'];
        $r_senha = $_POST['r_senha'];
        $r_nome = $_POST['r_nome'];
        $r_nivel = $_POST['r_nivel'];

        $sql_r = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$r_usuario}'") or die (mysql_error());
        $resultado_r = mysqli_num_rows($sql_r);

        echo $r_nome;
        exit;

        if($resultado_r != 0){
            $resultado = 0;
        } else {
            $registrar = mysqli_query($conectar, "INSERT INTO usuarios(usuario, nome, senha, nivel) VALUES ('$r_usuario', '$r_nome', '$r_senha', '$r_nivel')");

            $resultado = 1;
        }
    }

    echo $resultado;
    exit;
?>