<?php

  // FN 1 == LISTAR LIVROS NO DIA
  // FN 2 == LISTAR TOTAL DE LIVROS, IGUAL NO CONSULTA LOCAL

  include "../cfg.php";
  include "../funcoesGerais.php";

  function contarLivrosDia($ano, $mes, $dia){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM consulta_local WHERE ano='{$ano}' AND mes='{$mes}' AND dia='{$dia}'");
    $i = 0;
    if(verificarSql($sql)){
      $dado = mysqli_fetch_array($sql);
      $dados = explode("\r\n", $dado['codigos']);

      while(isset($dados[$i])){
        $i++;
      }

      return $i;
    }
  }

  function vasculhar($ano, $mes, $dia){
    if($dia>32){
      return;
    } else {
      $i = contarLivrosDia($ano, $mes, $dia);
      if($i != 0){
        // PRINTF ..
      }
      $dia++;
      vasculhar($ano, $mes, $dia);
    }

    // PRINTF TOTAL
  }

  $ano = retornaData(mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"));
  $mes = retornaData(mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"));
  $dia = retornaData(mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"));

  if(isset($_POST['fn']) && $_POST['fn'] == 1){

    printf("<p id='livrosRegistradosHoje'>Livros registrados hoje: <b>%d</b>.</p>", contarLivrosDia($ano, $mes, $dia));
    exit;

  }

  if(isset($_POST['fn']) && $_POST['fn'] == 2){

    vasculhar($_POST['ano'], $_POST['mes'], 1);

    exit;

  }

?>
