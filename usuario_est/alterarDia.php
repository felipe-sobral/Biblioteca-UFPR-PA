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
                    <hr>

                      <div class='form-group'>
                          <label for='manha'>Quantidade/ Manhã</label>
                          <input type='number' min='0' class='form-control' id='manha_alterar' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='tarde'>Quantidade/ Tarde</label>
                          <input type='number' min='0' class='form-control' id='tarde_alterar' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='noite'>Quantidade/ Noite</label>
                          <input type='number' min='0' class='form-control' id='noite_alterar' value='%d'>
                      </div>
                      <fieldset disabled>
                        <div class='form-group'>
                          <label for='mes'>Mês (Número)</label>
                          <input type='number' min='0' max='12' class='form-control' id='mes_alterar' value='%d'>
                        </div>

                        <div class='form-group'>
                          <label for='ano'>Ano</label>
                          <input type='number' min='0' class='form-control' id='ano_alterar' value='%d'>
                        </div>

                        <div class='form-group'>
                          <label for='data'>Data (AAAA-MM-DD)</label>
                          <input type='text' maxlength='10' class='form-control' id='data_alterar' value='%s'>
                        </div>
                      </fieldset disabled>


                  ", $manha, $tarde, $noite, $mes, $ano, $data);


        } else {
          $falhou = 1;
        }


      } else {
        $falhou = 1;
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
          echo 1;
        }

        if($alterarDados == 1){
          $manha = $_POST['manha'];
          $tarde = $_POST['tarde'];
          $noite = $_POST['noite'];

          mysqli_query($GLOBALS['conectar'], "UPDATE estatistica_usuarios SET manha = '{$manha}', tarde = '{$tarde}', noite = '{$noite}' WHERE data = '{$data}'");
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
