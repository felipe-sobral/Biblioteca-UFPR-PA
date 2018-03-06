<?php
    /*

      NOTAS:

      ** ARRUMAR MODALS DO BOTÃO COM BOOSTRAP (MELHOR OPÇÃO)

    */

    session_start();

    function login_erro(){
        header("Location: login.html");
    }

    include "cfg.php";

    if(!isset($_SESSION['usuario'], $_SESSION['senha'], $_SESSION['nivel'])){
        login_erro();
    }

    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];
    $nivel = $_SESSION['nivel'];

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'");
    $login_check = mysqli_num_rows($sql);

    if($login_check != 1){
        login_erro();
    }
?>

<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Biblioteca UFPR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/main.js"></script>
    <script src="js/jquery-3.3.1.js"></script>

    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
</head>
<body>
    <div class="container-fluid barraCima" style="text-align: right">
        <a href="logout.php"><button class="btn btn-dark btn-sm">Sair</button></a>

    </div>

    <div class="container-fluid cabecalho text-light">
        <h1>BIBLIOTECA UFPR</h1>
    </div>

    <div class="container">
      <div class="row" style="padding-top: 1%">
        <div class="col-sm d-block">

          <div class="card">
              <div class="card-body">
                <h5 class="card-title" id="bemvindo">Bem-vindo</h5>
             </div>
          </div>

        </div>
      </div>

      <div class="row" style= "padding-top: 1%">
        <div class="col-sm-3">

          <!-- BOTÕES -->
          <div id="botoes" class="card">
            <h5 class="card-header">Opções</h5>
            <div class="card-body">

              <div class="btn-group-vertical btn-block">
                <button id="registrarUsuarioBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarUsuario">
                  Registrar Usuário
                </button>

                <button id="registrarLivroBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarLivro">
                  Registrar Livro
                </button>
              </div>

              <!-- MODAL REGISTRAR USUARIO -->
              <div class="modal fade" id="registrarUsuario" tabindex="-1" role="dialog" aria-labelledby="registrarUsuario" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="registrarUsuario">Registrar Usuário</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form id="registrarForm">
                          <div id="erroRegistrar" class="alert alert-danger" role="alert">
                              <b>Algo está errado</b>. O usuário já existe ou campos estão vazios!
                          </div>
                          <div id="registroRealizado" class="alert alert-success" role="alert">
                              <b>Usuário cadastrado!</b>
                          </div>

                          <div class="form-group">
                              <label for="usuario">Usuário</label>
                              <input type="text" class="form-control" id="r_usuario" placeholder="Ex: maria">
                          </div>
                          <div class="form-group">
                              <label for="nome">Nome</label>
                              <input type="text" class="form-control" id="r_nome" placeholder="Ex: Maria">
                          </div>
                          <div class="form-group">
                              <label for="senha">Senha</label>
                              <input type="password" class="form-control" id="r_senha" placeholder="Senha">
                          </div>
                          <div class="form-group">
                              <label for="nivel">Nível do usuário</label>
                              <input type="number" class="form-control" id="r_nivel" placeholder="Min: 1 ~ Max: 5" min="1" max="5">
                          </div>

                          <center>
                            <button type="submit" class="btn btn-success">Registrar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          </center>
                      </form>

                    </div>
                    <!-- FOOTER AQUI -->
                  </div>
                </div>
              </div>
              <!-- FIM MODAL -->

              <!-- MODAL REGISTRAR LIVRO -->
              <div class="modal fade" id="registrarLivro" tabindex="-1" role="dialog" aria-labelledby="registrarLivro" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="registrarLivro">Registrar Livro</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form id="registrarFormLivro">
                          <div id="erroRegistrarLivro" class="alert alert-danger" role="alert">
                              <b>Algo está errado</b>. O livro já foi cadastrado ou campos estão vazios!
                          </div>
                          <div id="registroRealizadoLivro" class="alert alert-success" role="alert">
                              <b>Livro cadastrado!</b>
                          </div>

                          <div class="form-group">
                              <label for="l_nome">Nome</label>
                              <input type="text" class="form-control" id="l_nome" placeholder="Ex: Histologia básica">
                          </div>
                          <div class="form-group">
                              <label for="l_codigo">Codigo (ISBN)</label>
                              <input type="text" class="form-control" id="l_codigo" placeholder="Ex: 9788527714020">
                          </div>
                          <div class="form-group">
                              <label for="l_barra">Endereço</label>
                              <input type="text" class="form-control" id="l_barra" placeholder="Ex: 001.8 M294">
                          </div>
                          <div class="form-group">
                              <label for="l_link">Link do título (Sophia)</label>
                              <input type="text" class="form-control" id="l_link" placeholder="Ex: http://200.17.203.155/index.php?codigo_sophia=233296">
                          </div>
                          <div class="form-group">
                              <label for="l_estante">Estante</label>
                              <input type="text" class="form-control" id="l_estante" placeholder="Ex: 1A">
                          </div>
                          <div class="form-group">
                              <label for="l_ativo">Ativo (0 = NÃO | 1 = SIM)</label>
                              <input type="number" class="form-control" id="l_ativo" placeholder="Min: 0 ~ Max: 1" min="0" max="1">
                          </div>

                          <center>
                            <button type="submit" class="btn btn-success">Registrar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          </center>
                      </form>

                    </div>
                    <!-- FOOTER AQUI -->
                  </div>
                </div>
              </div>
              <!-- FIM MODAL -->

            </div>
          </div>

        </div>

        <div class="col-sm">


          <div class="card mb-3">
            <img class="card-img-top" src="img/bg-adm.jpg">
            <div class="card-body">
              <h5 class="card-title">Em construção</h5>
              <p class="card-text">Página em construção</p>
              <p class="card-text"><small class="text-muted">Previsão?</small></p>
            </div>
          </div>


        </div>

      </div>
    </div>




    <div class="container-fluid footer text-light" style="text-align: center">
        UFPR Biblioteca PA

    </div>

    <script>
        $(document).ready(function(){
            $('#registrarUsuarioBtn').prop('disabled', true);
            $('#registrarLivro').prop('disabled', true);
            $('#erroRegistrar').hide();
            $('#registroRealizado').hide();
            $('#erroRegistrarLivro').hide();
            $('#registroRealizadoLivro').hide();

            $.ajax({
                url: "verificar.php",
                type: "post",
                data: "executarFuncao="+1,
                success: function(result){
                    if(result>0){
                      $('#registrarLivro').prop('disabled', false);
                    }

                    if(result==5){
                      $("#registrarUsuarioBtn").prop('disabled', false);
                    }
                }

            })

            $.ajax({
              url: "verificar.php",
              type: "post",
              data: "executarFuncao="+4,
              success: function(result){
                jQuery("#bemvindo").html("<h5 class='card-title' id='bemvindo'>Bem-vindo, "+result.toString()+".</h5>");
              }

            })

            $('#registrarForm').submit(function(){
                var r_usuario=$('#r_usuario').val();
                var r_nome=$('#r_nome').val();
                var r_senha=$('#r_senha').val();
                var r_nivel=$('#r_nivel').val();

                $.ajax({
                    url: "verificar.php",
                    type: "post",
                    data: "r_usuario="+r_usuario+
                          "&r_senha="+r_senha+
                          "&r_nome="+r_nome+
                          "&r_nivel="+r_nivel+
                          "&executarFuncao="+2,
                    success: function(result){
                        if(result==1){
                            $('#erroRegistrar').hide();
                            $('#registroRealizado').show();
                        }
                        if(result==0){
                            $('#erroRegistrar').show();
                            $('#registroRealizado').hide();
                        }
                    }
                })

                return false;
            })

            $('#registrarFormLivro').submit(function(){
                var l_nome=$('#l_nome').val();
                var l_codigo=$('#l_codigo').val();
                var l_barra=$('#l_barra').val();
                var l_link=$('#l_link').val();
                var l_estante=$('#l_estante').val();
                var l_ativo=$('#l_ativo').val();

                $.ajax({
                    url: "verificar.php",
                    type: "post",
                    data: "l_nome="+l_nome+
                          "&l_codigo="+l_codigo+
                          "&l_barra="+l_barra+
                          "&l_link="+l_link+
                          "&l_estante="+l_estante+
                          "&l_ativo="+l_ativo+
                          "&executarFuncao="+3,
                    success: function(result){
                        if(result==1){
                            $('#erroRegistrarLivro').hide();
                            $('#registroRealizadoLivro').show();
                        }
                        if(result==0){
                            $('#erroRegistrarLivro').show();
                            $('#registroRealizadoLivro').hide();
                        }
                    }
                })

                return false;
            })

        })
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
