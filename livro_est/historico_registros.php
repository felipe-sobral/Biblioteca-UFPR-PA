<?php

  // FN 1 == LISTAR LIVROS NO DIA
  // FN 2 == LISTAR TOTAL DE LIVROS, IGUAL NO CONSULTA LOCAL

  include "../cfg.php";

  if(isset($_POST['fn']) && $_POST['fn'] == 1){
    $sql_ano = mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)");
    $sql_mes = mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)");
    $sql_dia = mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)");

    $ano = mysqli_fetch_row($sql_ano); $ano = $ano[0];
    $mes = mysqli_fetch_row($sql_mes); $mes = $mes[0];
    $dia = mysqli_fetch_row($sql_dia); $dia = $dia[0];

    $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE")
  }

?>
