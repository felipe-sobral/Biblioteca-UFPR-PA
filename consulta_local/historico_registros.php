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

  function colocaZero($num){
    if($num > 0 && $num < 10){
      return "0"."$num";
    } else {
      return $num;
    }
  }

  function vasculhar($ano, $mes, $dia, $total){
    if($dia>32){
      printf("
          <tr style='background-color: #dee2e8; font-weight: bold;'>
            <td>TOTAL</td>
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
            <td>%s-%s-%d</td>
            <td>%d</td>
          </tr>

          ", colocaZero($dia), colocaZero($mes), $ano, $i);
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

    printf("<span id='livrosRegistradosHoje'>%d</span>", contarLivrosDia($ano, $mes, $dia));
    exit;

  }

  if(isset($_POST['fn']) && $_POST['fn'] == 2){
    $ano = preg_replace('/[^0-9_]/', '',$_POST['ano']);
    $mes = preg_replace('/[^0-9_]/', '',$_POST['mes']);
    gravar_log("Consultou histórico consulta local [".$mes."-".$ano."] * [#117#]");

    printf("

    <table class='responsive-table'>
      <thead>
        <tr>
          <th>Data</th>
          <th>livros</th>
        </tr>
      </thead>
      <tbody>

    ", colocaZero($mes), $ano);

    vasculhar($ano, $mes, 1, 0);

    exit;

  }

?>
