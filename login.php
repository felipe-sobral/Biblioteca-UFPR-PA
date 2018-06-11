<?php
    include "cfg.php";
    include "funcoesGerais.php";

    $user = $_POST['usuario'];
    $pass = $_POST['senha'];
    $funcao = $_POST['funcao'];

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$user}' AND senha = '{$pass}'") or die (mysql_error());

    $dado = mysqli_fetch_array($sql);
    $resultado = mysqli_num_rows($sql);

    $retorno = 0;

    if($funcao == 0){
        if($resultado == 0){
            $retorno = 0;
        } else {
            if(!isset($_SESSION)){
                session_start();
                $_SESSION['id'] = $dado['id'];
                $_SESSION['nome'] = $dado['nome'];
                $_SESSION['senha'] = $dado['senha'];
                $_SESSION['usuario'] = $dado['usuario'];
                $_SESSION['nivel'] = $dado['nivel'];
            }
            $retorno = 1;
            gravar_log("Fez login * [#125#]");
        }
    }

    echo $retorno;
    exit;
?>
