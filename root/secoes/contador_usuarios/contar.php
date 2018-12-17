<?php
    session_start();

    if(!isset($_SESSION) or !isset($_SESSION['usuario'])){
        echo "OPS... =(";
        return false;
    }

    require "../../init.php";
 
    $horas = date('G')-3;
    $hoje = date('Y-m-d');
    $stat = isset($_POST['stat']) ? $_POST['stat']:1;
    $quantidade = 1;

    if($stat < 0){
        $quantidade = -1;
    }
        
    if(checkUsuario($_SESSION['usuario'], 2)){

        $numero_rows = db_countRows("e_usuarios", "data", ["data", $hoje]);

        if($numero_rows[0] == 0){
            db_insert("e_usuarios", ["data" => $hoje]);
        }

        switch ($horas) {
            case ($horas >= 7 && $horas < 12):
                db_contador("manha", ["quantidade" => $quantidade, "data" => $hoje]);
            break;
        
            case ($horas >= 12 && $horas < 18):
                db_contador("tarde", ["quantidade" => $quantidade, "data" => $hoje]);
            break;
        
            case ($horas >= 18 && $horas < 23):
                db_contador("noite", ["quantidade" => $quantidade, "data" => $hoje]);
            break;
        }

    }
    