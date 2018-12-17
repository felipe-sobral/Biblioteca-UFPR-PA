<?php

    session_start();

    /*if(!isset($_SESSION) or !isset($_SESSION['usuario'])){
        echo "OPS... =(";
        return false;
    }*/

    require "../../init.php";

    $usuario = "felipe";
    $senha = "krp";
    $nome = "Felipe Sobral";
    $email = "xfelipesobral@gmail.com";
    $nivel = 5;
    $stat = 1;

    $dados_usuario = [
                      "usuario" => $usuario,
                      "senha" => $senha,
                      "nome" => $nome,
                      "email" => $email,
                      "nivel" => $nivel,
                      "stat" => $stat,
                     ];

    db_insert("usuarios", $dados_usuario);

    echo "REGISTRADO =D";

