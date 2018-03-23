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
        echo 0;
      break;
  }

  function procurarData($codigo_procurar){
    $autorizar = verificarNivel('3');

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

                    <form id='alterarDiaFormX'>

                      <div class='form-group'>
                          <label for='manha'>Quantidade/ Manhã</label>
                          <input type='number' class='form-control' id='manha' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='tarde'>Quantidade/ Tarde</label>
                          <input type='number' class='form-control' id='tarde' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='noite'>Quantidade/ Noite</label>
                          <input type='number' class='form-control' id='noite' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='mes'>Mês (Número)</label>
                          <input type='number' class='form-control' id='mes' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='ano'>Ano</label>
                          <input type='number' class='form-control' id='ano' value='%d'>
                      </div>
                      <div class='form-group'>
                          <label for='data'>Data (AAAA-MM-DD)</label>
                          <input type='text' maxlength='10' class='form-control' id='data' value='%s'>
                      </div>

                  </form>

                  ", $manha, $tarde, $noite, $mes, $ano, $data);


        }

      }
    }


  /*
  if($verificar == 1){

    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];

    $a_codigo = $_POST['a_codigoAlterar'];

    $verificar_nivel = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'");
    $verificar_nivel_x = mysqli_num_rows($verificar_nivel);

    if($verificar_nivel_x==1){
      $obter_dado = mysqli_fetch_array($verificar_nivel);
      $nivel = $obter_dado['nivel'];

      if($nivel >= 3){
        $sql = mysqli_query($conectar, "SELECT * FROM livros WHERE codigo = '{$a_codigo}'");
        $verificar_livro = mysqli_num_rows($sql);

        if($verificar_livro == 1){

          $nome = $_POST['a_nome'];
          $barra = $_POST['a_barra'];
          $estante = $_POST['a_estante'];
          $link = $_POST['a_link'];
          $codigo = $_POST['a_codigo'];
          $codigo_a = $_POST['a_codigoAlterar'];

          mysqli_query($conectar, "UPDATE livros SET nome ='{$nome}', barra = '{$barra}', estante = '{$estante}', link = '{$link}', codigo = '{$codigo}' WHERE livros.codigo = '{$codigo_a}'");

          echo 1;

        } else {
          echo 0;
          exit;
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
  */
?>
