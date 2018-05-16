<?php

  // FN 1 == LISTAR LIVROS NO DIA
  // FN 2 == LISTAR TOTAL DE LIVROS, IGUAL NO CONSULTA LOCAL

  include "../cfg.php";
  include "../funcoesGerais";

  function contarLivrosDia($ano, $mes, $dia){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM consulta_local WHERE ano='{$ano}' AND mes='{$mes}' AND dia='{$dia}'");
    if(verificarSql($sql)){

    }
  }

  if(isset($_POST['fn']) && $_POST['fn'] == 1){
    $ano = retornaData(mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"));
    $mes = retornaData(mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"));
    $dia = retornaData(mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"));



  }

?>
