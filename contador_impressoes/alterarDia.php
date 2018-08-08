<?php

  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  $data_procurar = preg_replace('/[^0-9\-_]/', '',$_POST['data']);
  $verificar = preg_replace('/[^0-9_]/', '',$_POST['verificar']);

  switch ($verificar) {
    case 0:
        procurarData($data_procurar);
      break;

    case 1;
        alterarDiaFuncao($data_procurar);
      break;
  }

  function procurarData($codigo_procurar){
    $autorizar = verificarNivel('3');
    $falhou = 0;

    if($autorizar){
      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM impressao WHERE xdata='{$codigo_procurar}'");

      if(verificarSql($sql)){

        $dado = mysqli_fetch_array($sql);

          $total = $dado['total'];
          $mes = $dado['mes'];
          $ano = $dado['ano'];
          $data = $dado['xdata'];



          printf("

                      <div class='row'>
                        <div class='input-field col s6'>
                          <input type='text' class='form-control' id='a_valorIMP' value='%d'/>
                          <span class='helper-text'>Total</span>
                        </div>
                        <div class='input-field col s6 disabled'>
                          <input disabled type='text' maxlength='10' id='a_dataIMP' value='%s'>
                          <span class='helper-text'>Data (AAAA-MM-DD)</span>
                        </div>
                      </div>
                      <div class='row'>
                        <div class='input-field col s6'>
                          <input disabled value='%d' type='number' id='a_mesIMP'>
                          <span class='helper-text'>Mês (Número)</span>
                        </div>
                        <div class='input-field col s6'>
                          <input disabled type='number' id='a_anoIMP' value='%d'>
                          <span class='helper-text'>Ano</span>
                        </div>
                      </div>



                  ", $total, $data, $mes, $ano);


        } else {
          $falhou = 1;
          echo "<script>alert('Falhou [SQL]');</script>";
        }


      } else {
        $falhou = 1;
        echo "<script>alert('Falhou [NIVEL]');</script>";
      }

      if($falhou == 1){
        echo 0;
      }

    }



  function alterarDiaFuncao($data){

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM impressao WHERE xdata = '{$data}'");

    if(verificarNivel(3)){

      if(verificarSql($sql)){

        $alterarDados = $_POST['alterarDados'];

        if($alterarDados == 2){
          mysqli_query($GLOBALS['conectar'], "DELETE FROM impressao WHERE xdata = '{$data}'");
          gravar_log("Deletou estatística impressões [DATA:".$data."] * [#143#]");
          echo 1;
        }

        if($alterarDados == 1){
          $total = preg_replace('/[^0-9_]/', '',$_POST['total']);

          mysqli_query($GLOBALS['conectar'], "UPDATE impressao SET total = $total WHERE xdata = '{$data}'");
          gravar_log("Alterou estatística impressões [DATA:".$data."] * [#144#]");
          echo 1;
        }

      } else {
        echo 0;
        exit;
      }

    } else {
      echo 0;
      exit;
    }

}

?>
