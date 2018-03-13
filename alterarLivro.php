<?php

  session_start();

  include "cfg.php";

  $verificar = $_POST['verificar'];

  if($verificar == 0){
    $codigo_procurar = $_POST['c_livro'];
    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];

    $verificar_nivel = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'");
    $verificar_nivel_x = mysqli_num_rows($verificar_nivel);

    if($verificar_nivel_x==1){
      $obter_dado = mysqli_fetch_array($verificar_nivel);
      $nivel = $obter_dado['nivel'];

      if($nivel >= 3){
        $sql = mysqli_query($conectar, "SELECT * FROM livros WHERE codigo = '{$codigo_procurar}'");
        $verificar_livro = mysqli_num_rows($sql);

        if($verificar_livro == 1){
          $dados = mysqli_fetch_array($sql);

          $id = $dados['id'];
          $nome = $dados['nome'];
          $barra = $dados['barra'];
          $estante = $dados['estante'];
          $link = $dados['link'];
          $codigo = $dados['codigo'];

          printf("
                    <hr>

                    <form id='alterarFormLivroX'>

                      <input type='text' id='a_codigoAlterar' value='%s' style='display: none'>

                      <div class='form-group'>
                          <label for='a_nome'>Nome <small class='text-muted'>Máximo de caracteres: 100</small></label>
                          <input type='text' maxlength='100' class='form-control' id='a_nome' value='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_codigo'>Codigo (ISBN) <small class='text-muted'>Máximo de caracteres: 20</small></label>
                          <input type='text' maxlength='20' class='form-control' id='a_codigo' value='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_barra'>Endereço <small class='text-muted'>Máximo de caracteres: 30</small></label>
                          <input type='text' maxlength='30' class='form-control' id='a_barra' value='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_link'>Link do título (Sophia) <small class='text-muted'>Máximo de caracteres: 60</small></label>
                          <input type='text' maxlength='60' class='form-control' id='a_link' value='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_estante'>Estante <small class='text-muted'>Máximo de caracteres: 5</small></label>
                          <input type='text' maxlength='5' class='form-control' id='a_estante' value='%s'>
                      </div>

                  </form>

                  ", $dados['codigo'], $dados['nome'], $dados['codigo'], $dados['barra'], $dados['link'], $dados['estante']);
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
?>
