<?php

  /*
    TESTE DE FUNCIONALIDADES

    ID - IDENTIFICAÇÃO DO TESTE
    ---------------------------
    01 - ADICIONAR 1 USUÁRIO (contador_usuario/painel.html)
    02 - REMOVER 1 USUÁRIO (contador_usuario/painel.html)
    03 - ADICIONAR 1 LIVRO NO CONSULTA LOCAL (consulta_local/registrar_codigos.html)
    04 - TESTAR COERÊNCIA DO "Livros registrados hoje" (consulta_local/registrar_codigos.html)

  */

  include "../cfg.php";
  include "../funcoesGerais";

  $erros;
  $passou;

  //01 - ADICIONAR 1 USUÁRIO (contador_usuario/painel.html)
  function adicionar($pessoas, $hora_br, $data){
    $conectar = $GLOBALS['conectar'];
    $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
      $contagem = mysqli_fetch_array($sql);
      switch ($hora_br) {
        case ($hora_br >= 7 && $hora_br < 12): // PARTE MANHÃ 07:30 ÀS 12:00
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET manha = manha+1 WHERE data = '{$data}'");
          echo $contagem['manha']+1;
        break;

        case ($hora_br >= 12 && $hora_br < 18): // PARTE TARDE 12:00 ÀS 18:00
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET tarde = tarde+1 WHERE data = '{$data}'");
          echo $contagem['tarde']+1;
        break;

        case ($hora_br >= 18 && $hora_br < 23): // PARTE NOITE 18:00 ÀS 19:30
          mysqli_query($conectar, "UPDATE estatistica_usuarios SET noite = noite+1 WHERE data = '{$data}'");
          echo $contagem['noite']+1;
        break;
      }
    } else {
    }
  }

  function test1($numero, $hora, $data, $turno){
    adicionar($numero, $hora_br, $data);
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM estatistica_usuarios WHERE data = '{$data}'");
    if(verificarSql($sql)){
        $test = mysqli_fetch_array($sql);
        if($test[$turno] == $numero && $test['data'] == $data){
          $passou++;
          echo "01 - ADICIONAR 1 USUÁRIO (contador_usuario/painel.html) ** PASSOU";
          exit;
        }
    }
    $erros++;
    echo "01 - ADICIONAR 1 USUÁRIO (contador_usuario/painel.html) ** NÃO PASSOU";
  }


    // BUSCAR CONFIRMAR

 ?>
