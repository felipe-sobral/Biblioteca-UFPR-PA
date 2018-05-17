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

      if($i==0){
        return $dado['id'];
      } else {
        return $i;
      }
    } else {
      return false;
    }
  }

  function vasculhar($ano, $mes, $dia, $total){
    if($dia>32){
      printf("
          <tr>
            <td class='collapsing'>TOTAL</td>
            <td>%d</td>
          </tr>
        </tbody>
      </table>

      ", $total);

      return;
    } else {
      $i = contarLivrosDia($ano, $mes, $dia);
      if($i != false){
        if($i > 0){
          printf("

          <tr>
            <td class='collapsing'>%d-%d-%d</td>
            <td>%d</td>
          </tr>

          ", $dia, $mes, $ano, $i);
        } else {
          mysqli_query($GLOBALS['conectar'], "DELETE FROM `consulta_local` WHERE id='{$id}'");
        }
      }
      $dia++;
      $total = $total+$i;
      vasculhar($ano, $mes, $dia, $total);
    }

  }

  $ano = retornaData(mysqli_query($conectar, "SELECT YEAR(CURRENT_TIMESTAMP)"));
  $mes = retornaData(mysqli_query($conectar, "SELECT MONTH(CURRENT_TIMESTAMP)"));
  $dia = retornaData(mysqli_query($conectar, "SELECT DAY(CURRENT_TIMESTAMP)"));

  if(isset($_POST['fn']) && $_POST['fn'] == 1){

    printf("<p id='livrosRegistradosHoje'>Livros registrados hoje: <b>%d</b>.</p>", contarLivrosDia($ano, $mes, $dia));
    exit;

  }

  if(isset($_POST['fn']) && $_POST['fn'] == 2){

    printf("

    <table class='ui celled striped table'>
      <thead>
        <tr><th colspan='2'>
          Histórico consulta local %d-%d
        </th>
      </tr></thead>
      <tbody>

    ", $_POST['mes'], $_POST['ano']);

    vasculhar($_POST['ano'], $_POST['mes'], 1, 0);

    exit;

  }

?>
