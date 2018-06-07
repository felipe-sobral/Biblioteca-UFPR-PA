<?php

  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  $data_procurar = $_POST['data'];
  $verificar = $_POST['verificar'];

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
      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM estatistica_usuarios WHERE data='{$codigo_procurar}'");

      if(verificarSql($sql)){

        $dado = mysqli_fetch_array($sql);

          $manha = $dado['manha'];
          $tarde = $dado['tarde'];
          $noite = $dado['noite'];
          $mes = $dado['n_mes'];
          $ano = $dado['ano'];
          $data = $dado['data'];



          printf("

                      <div class='row'>
                        <div class='input-field col s6'>
                          <input placeholder='x' type='number' min='0' id='manha_alterar' value='%d'>
                          <span class='helper-text' data-error='wrong' data-success='right'>Quantidade/ Manhã</span>
                        </div>
                        <div class='input-field col s6'>
                          <input placeholder='x' value='%d' type='number' min='0' id='tarde_alterar'>
                          <span class='helper-text' data-error='wrong' data-success='right'>Quantidade/ Tarde</span>
                        </div>
                      </div>

                      <div class='row'>
                        <div class='input-field col s6'>
                          <input placeholder='x' type='number' min='0' id='noite_alterar' value='%d'>
                          <span class='helper-text' data-error='wrong' data-success='right'>Quantidade/ Noite</span>
                        </div>
                        <div class='input-field col s6'>
                          <input disabled placeholder='x' value='%d' type='number' min='0' max='12' id='mes_alterar' >
                          <span class='helper-text' data-error='wrong' data-success='right'>Mês (Número)</span>
                        </div>
                      </div>

                      <div class='row'>
                        <div class='input-field col s6'>
                          <input disabled placeholder='x' type='number' min='0' id='ano_alterar' value='%d'>
                          <span class='helper-text' data-error='wrong' data-success='right'>Ano</span>
                        </div>
                        <div class='input-field col s6 disabled'>
                          <input disabled placeholder='x' type='text' maxlength='10' id='data_alterar' value='%s'>
                          <span class='helper-text' data-error='wrong' data-success='right'>Data (AAAA-MM-DD)</span>
                        </div>
                      </div>


                  ", $manha, $tarde, $noite, $mes, $ano, $data);


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

    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");

    if(verificarNivel(3)){

      if(verificarSql($sql)){

        $alterarDados = $_POST['alterarDados'];

        if($alterarDados == 2){
          mysqli_query($GLOBALS['conectar'], "DELETE FROM estatistica_usuarios WHERE data = '{$data}'");
          gravar_log("Deletou estatística usuário [DATA:".$data."] * [118]");
          echo 1;
        }

        if($alterarDados == 1){
          $manha = $_POST['manha'];
          $tarde = $_POST['tarde'];
          $noite = $_POST['noite'];

          mysqli_query($GLOBALS['conectar'], "UPDATE estatistica_usuarios SET manha = '{$manha}', tarde = '{$tarde}', noite = '{$noite}' WHERE data = '{$data}'");
          gravar_log("Alterou estatística usuário [DATA:".$data."] * [119]");
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
