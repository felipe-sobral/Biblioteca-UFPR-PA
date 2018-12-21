<?php
    session_start();

    if(!isset($_SESSION) or !isset($_SESSION['usuario'])){
        echo "OPS... =(";
        return false;
    }

    require "../../init.php";
 
    if(checkUsuario($_SESSION['usuario'], 2)){
        
        $horas = date('G')-3;
        $hoje = date('Y-m-d');
        $stat = isset($_POST['stat']) ? $_POST['stat']:1;
        $turno = turno($horas);
        $quantidade = 1;

        if($stat == 0){
            #SELECT turno FROM e_usuarios WHERE data=data;
            $query = new Query;
            $contador = $query->select(["e_usuarios"], ['*'])->parametro("data", "=", $date)->construir()->array_assoc();
            
            if($contador == null){
                $query->insert("e_usuarios", [$date, 0, 0, 0])->construir();
                echo "0";
                return;
            }

            echo $contador[$turno];
            return;
        }

        if($stat < 0){
            $quantidade = -1;
        }

        ## CONTINUAR DAQUI

        $select = new Query;
        $update = new Query;

        $select = $select->select(["e_usuarios"], [$turno])->parametro("data", "=", $hoje)->retornarQuery();
        $update = $update->update("e_usuarios")->parametro($turno, "= {$turno} +", $quantidade)->where()->parametro("data", "=", $hoje)->retornarQuery();
        
        $final = $final->addQuery($update."; ".$select)->print();

    }


    function turno($horas){
        switch ($horas) {
            case ($horas >= 7 && $horas < 12):
                return "manha";
            break;
        
            case ($horas >= 12 && $horas < 18):
                return "tarde";
            break;
        
            case ($horas >= 18 && $horas < 23):
                return "noite";
            break;
        }
    }
    