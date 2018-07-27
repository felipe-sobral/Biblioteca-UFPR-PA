<?php

  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(is_null($_POST['codigos'])){
    echo 0;
    exit;
  }

  $codigos = addslashes($_POST['codigos']);
  $dia = preg_replace('/[^0-9_]/', '',$_POST['dia']);
  $mes = preg_replace('/[^0-9_]/', '',$_POST['mes']);
  $ano = preg_replace('/[^0-9_]/', '',$_POST['ano']);

  if(verificarNivel(3)){

    $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE dia='{$dia}' AND mes='{$mes}' AND ano='{$ano}'");

    if(!verificarSql($sql)){
      $inserir = str_replace('<br />', '\r', nl2br($codigos));

      mysqli_query($conectar, "INSERT INTO consulta_local(dia, ano, mes, codigos) VALUES ('{$dia}', '{$ano}', '{$mes}', '{$inserir}')");
      gravar_log("Adicionou Consulta Local [".$dia."-".$mes."-".$ano."] * [#122#]");
      echo 1;
      exit;

    } else {
      echo 0;
      exit;
    }

  } else {
    echo 0;
    exit;
  }


?>
