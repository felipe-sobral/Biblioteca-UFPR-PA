<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
    require_once QUERY;

    if(!restrito(2)){
        retorna(false, "ACESSO NEGADO!");
    }

    $horas = date("G")-3;
    $hoje = date("Y-m-d");
    $stat = isset($_POST["stat"]) ? $_POST["stat"]:1;
    $turno = turno($horas);
    $quantidade = 1;

    $query = new Query;

    if($stat == 0){
        $vHoje = $query->valor("data", $hoje);

        $query->selecionar("e_usuarios", "*", "data = $vHoje");
        $query->executar();

        $contador = $query->assoc_array();
        
        if(!$contador){
            $query->inserir("e_usuarios", ["data" => $hoje, "manha" => 0, "tarde" => 0, "noite" => 0]);
            $query->executar();

            retorna(true, "0");
        }

        retorna(true, $contador[0][$turno]);
    }

    if($stat < 0){
        $quantidade = -1;
    }

    $update = new Query;

    $vData = $update->valor("data", $hoje);
    $vData = $query->valor("data", $hoje);

    $update->alterar("e_usuarios", [$turno => "@$turno + $quantidade@"], "data = $vData");
    $query->selecionar("e_usuarios", "$turno", "data = $vData");

    $update->executar();
    $query->executar();

    $quantidade_pessoas = $query->assoc_array();

    retorna(true, $quantidade_pessoas[0][$turno]);

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
    