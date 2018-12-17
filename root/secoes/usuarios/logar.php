<?php
    require "../../init.php";

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $dados = autenticarUsuario($usuario, $senha);

    if($dados != false){
        session_start();
        $_SESSION['id'] = $dados['id'];
        $_SESSION['usuario'] = $dados['usuario'];
        $_SESSION['senha'] = $dados['senha'];
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['email'] = $dados['email'];
        $_SESSION['nivel'] = $dados['nivel'];
        $_SESSION['stat'] = $dados['stat'];

        echo "#true";
        exit;
    }
    
    echo "#false";
