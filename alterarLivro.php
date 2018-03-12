<?php

  session_start();

  include "cfg.php";

  $verificar = $_POST['verificar'];

  if($verificar == 0){
    $codigo_procurar = $_POST['codigo'];
    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];

    $verificar_nivel = mysqli_query($conectar, "SELECT * FROM livros WHERE usuario = '{$usuario}' AND senha = '{$senha}'");
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

          <!-- MODAL REGISTRAR LIVRO -->
          <div class='modal fade' id='alterarLivro' tabindex='-1' role='dialog' aria-labelledby='alterarLivro' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h3 class='modal-title' id='alterarLivro'>Alterar Livro</h3>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>

                  <form id='alterarFormLivro'>

                      <div class='form-group'>
                          <label for='a_nome'>Nome <small class='text-muted'>Máximo de caracteres: 100</small></label>
                          <input type='text' maxlength='100' class='form-control' id='a_nome' placeholder='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_codigo'>Codigo (ISBN) <small class='text-muted'>Máximo de caracteres: 20</small></label>
                          <input type='text' maxlength='20' class='form-control' id='a_codigo' placeholder='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_barra'>Endereço <small class='text-muted'>Máximo de caracteres: 30</small></label>
                          <input type='text' maxlength='30' class='form-control' id='a_barra' placeholder='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_link'>Link do título (Sophia) <small class='text-muted'>Máximo de caracteres: 60</small></label>
                          <input type='text' maxlength='60' class='form-control' id='a_link' placeholder='%s'>
                      </div>
                      <div class='form-group'>
                          <label for='a_estante'>Estante <small class='text-muted'>Máximo de caracteres: 5</small></label>
                          <input type='text' maxlength='5' class='form-control' id='a_estante' placeholder='%s'>
                      </div>

                      <center>
                        <button type='submit' class='btn btn-success'> <i class='fas fa-check'></i> Registrar</button>
                        <button type='button' class='btn btn-danger' data-dismiss='modal'> <i class='fas fa-times'></i> Fechar</button>
                      </center>
                  </form>

                </div>
                <!-- FOOTER AQUI -->
              </div>
            </div>
          </div>
          <!-- FIM MODAL -->

                  ", $dados['nome'], $dados['codigo'], $dados['barra'], $dados['link'], $dados['estante']);
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
