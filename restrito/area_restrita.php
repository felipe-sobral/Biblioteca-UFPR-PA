<?php
    session_start();

    function login_erro(){
        header("Location: ../login.html");
    }

    include "../cfg.php";

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

    <script src="../js/main.js"></script>
    <script src="../js/jquery-3.3.1.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <link rel="stylesheet" href="../css/main.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
</head>
<body class="bodyPadrao">

    <div class="container containerSombra">
      <div class="row" style="background-image: url('../img/bg.jpg');">
        <div class="col-sm">

          <div class="text-light container-principal-espacemento">
            <img src="../img/branco_UFPR.png"/>
          </div>

        </div>
      </div>


      <div class="row" style="background-color: #fff; padding-top: 2%;">
        <div class="col-sm">

          <div class="container">
            <div class="row" style="padding-top: 1%">
              <div class="col-sm d-block">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" id="bemvindo">Bem-vindo</h5>
                    <a><i class="fas fa-exclamation-triangle"></i> Para melhor utilização, é recomendado que use o navegador <b><i class="fab fa-chrome"></i> Google Chrome</b> ou <b><i class="fab fa-firefox"></i> Firefox</b>.</a>
                  </div>
                </div>

              </div>
            </div>

            <div class="row" style= "padding-top: 1%">
              <div class="col-sm-3">

                <!-- BOTÕES -->
                <div id="botoes" class="card">
                  <h5 class="card-header"><i class="fas fa-cog"></i> Opções</h5>
                  <div class="card-body">

                    <div class="btn-group-vertical btn-block">
                      <button id="registrarUsuarioBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarUsuario">
                        <i class="fas fa-user-plus"></i> Registrar Usuário
                      </button>

                      <button id="registrarLivroBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarLivro">
                        <i class="fas fa-plus-square"></i> Registrar Livro
                      </button>

                      <button id="alterarLivroBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#alterarLivro">
                        <i class="fas fa-pencil-alt"></i> Alterar Livro
                      </button>

                      <a href="../listarLivros.php" target="_blank" class="btn btn-primary">
                        <i class="fas fa-clipboard-list"></i> Livros Registrados
                     </a>

                     <a href="../usuario_est/estatistica_usuarios.html" class="btn btn-primary">
                       Contador de Usuários
                    </a>
                    </div>

                    <!-- MODAL REGISTRAR USUARIO -->
                    <div class="modal fade" id="registrarUsuario" tabindex="-1" role="dialog" aria-labelledby="registrarUsuario" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title" id="registrarUsuario"> Registrar Usuário</h3>
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
                              <label for="usuario">Usuário <small class="text-muted">Máximo de caracteres: 20</small></label>
                              <input type="text" maxlength="20" class="form-control" id="r_usuario" placeholder="Ex: maria">
                          </div>
                          <div class="form-group">
                              <label for="nome">Nome <small class="text-muted">Máximo de caracteres: 60</small></label>
                              <input type="text" maxlength="60" class="form-control" id="r_nome" placeholder="Ex: Maria">
                          </div>
                          <div class="form-group">
                              <label for="senha">Senha <small class="text-muted">Máximo de caracteres: 10</small></label>
                              <input type="password" maxlength="10" class="form-control" id="r_senha" placeholder="Senha">
                          </div>
                          <div class="form-group">
                              <label for="nivel">Nível do usuário</label>
                              <input type="number" class="form-control" id="r_nivel" placeholder="Min: 1 ~ Max: 5" min="1" max="5">
                          </div>

                          <center>
                            <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Registrar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Fechar</button>
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
                                <label for="l_nome">Nome <small class="text-muted">Máximo de caracteres: 100</small></label>
                                <input type="text" maxlength="100" class="form-control" id="l_nome" placeholder="Ex: Histologia básica">
                            </div>
                            <div class="form-group">
                                <label for="l_codigo">Codigo (ISBN) <small class="text-muted">Máximo de caracteres: 20</small></label>
                                <input type="text" maxlength="20" class="form-control" id="l_codigo" placeholder="Ex: 9788527714020">
                            </div>
                            <div class="form-group">
                                <label for="l_barra">Endereço <small class="text-muted">Máximo de caracteres: 30</small></label>
                                <input type="text" maxlength="30" class="form-control" id="l_barra" placeholder="Ex: 001.8 M294">
                            </div>
                            <div class="form-group">
                                <label for="l_link">Link do título (Sophia) <small class="text-muted">Máximo de caracteres: 60</small></label>
                                <input type="text" maxlength="60" class="form-control" id="l_link" placeholder="Ex: http://200.17.203.155/index.php?codigo_sophia=233296">
                            </div>
                            <div class="form-group">
                                <label for="l_estante">Estante <small class="text-muted">Máximo de caracteres: 5</small></label>
                                <input type="text" maxlength="5" class="form-control" id="l_estante" placeholder="Ex: 1A">
                            </div>

                            <center>
                              <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Registrar</button>
                              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Fechar</button>
                            </center>
                        </form>

                      </div>
                      <!-- FOOTER AQUI -->
                    </div>
                  </div>
                </div>
                <!-- FIM MODAL -->

                <!-- MODAL ALTERAR LIVRO -->
                <div class="modal fade" id="alterarLivro" tabindex="-1" role="dialog" aria-labelledby="alterarLivro" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title" id="alterarLivro">Alterar Livro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form id="alterarFormLivro">
                            <div id="erroAlterarLivro" class="alert alert-danger" role="alert">
                                <b>Algo está errado</b>. Não foi possível realizar alterações!
                            </div>
                            <div id="errorProcurarLivro" class="alert alert-danger" role="alert">
                              <b>Algo está errado</b>. Não foi possível encontrar o livro!
                            </div>
                            <div id="certoAlterarLivro" class="alert alert-success" role="alert">
                                <b>Modificações cadastradas!</b>
                            </div>

                            <div id="procurarLivro" style="display: block">
                              <div class="form-group">
                                <label for="c_livro">Codigo do livro</label>
                                <input type="text" class="form-control" id="c_livro" placeholder="Ex: 9788527714020">
                              </div>


                              <center>
                                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-search"></i> Procurar</button>
                              </center>
                            </div>
                        </form>

                        <div id="aposProcurar"  style="display: none">
                            <form id='alterarFormLivroX'>

                                <a id="formularioDoLivro">
                                <!--
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
                                -->

                                </a>

                            <center>
                              <button type='submit' class='btn btn-success'> <i class='fas fa-check'></i> Alterar</button>
                              <button type='button' class='btn btn-danger' data-dismiss='modal'> <i class='fas fa-times'></i> Fechar</button>
                            </center>
                          </form>
                        </div>

                      </div>
                      <!-- FOOTER AQUI -->
                    </div>
                  </div>
                </div>
                <!-- FIM MODAL -->

              </div>
            </div>

          </div>

          <div class="col-sm padding-bottom: 2%;">


            <div class="card mb-3">
              <img class="card-img-top" src="../img/bg-adm.jpg">
              <div id="livrosP" class="card-body">
                <h5 class="card-title">Livros Pendentes</h5>
                <p class="card-text">

                  <div>

                    <form id="alterarVisibilidade" class="form-inline">
                      <div class="form-group mx-sm-3 mb-2 col-auto my-1">
                        <input type="text" class="form-control" id="id_l" placeholder="ID do Livro">
                      </div>
                      <div class="form-group mx-sm-3 mb-2 col-auto my-1">
                        <select class="custom-select mr-sm-2" id="valor_l">
                          <option selected value="1">Ativar</option>
                          <option value="2">Excluir</option>
                        </select>
                      </div>
                      <button id="sub_livro" type="submit" class="btn btn-outline-info mb-2"><i class='fas fa-check'></i> Aplicar</button>
                    </form>
                  <hr>
                  </div>

                  <a id="livrosPendentes"></a>

                </p>
              </div>
            </div>


          </div>

        </div>
      </div>




      <div class="row text-light rodape">
          <div class="col-sm">
              <div class="container-fluid rodape-texto">
                  <a href="https://www.facebook.com/krepper.fs" target="_blank"><img src="../img/minha_logo.png" alt="Felipe Sobral"/></a>  UFPR Biblioteca PA - <a href="../logout.php">Sair</a>
              </div>
          </div>
      </div>

      </div>
    </div>
  </div>

    <script>
        $(document).ready(function(){
            $('#registrarUsuarioBtn').prop('disabled', true);
            $('#registrarLivro').prop('disabled', true);
            $('#alterarLivroBtn').prop('disabled', true);

            $('#erroRegistrar').hide();
            $('#registroRealizado').hide();
            $('#erroRegistrarLivro').hide();
            $('#registroRealizadoLivro').hide();

            $('#erroAlterarLivro').hide();
            $('#errorProcurarLivro').hide();
            $('#certoAlterarLivro').hide();

            $.ajax({
                url: "../verificar.php",
                type: "post",
                data: "executarFuncao="+1,
                success: function(result){
                    if(result>0){
                      $('#registrarLivro').prop('disabled', false);
                    }

                    if(result>=3){
                      $('#alterarLivroBtn').prop('disabled', false);
                    }

                    if(result==5){
                      $("#registrarUsuarioBtn").prop('disabled', false);
                    }
                }

            })

            $.ajax({
              url: "../verificar.php",
              type: "post",
              data: "executarFuncao="+4,
              success: function(result){
                jQuery("#bemvindo").html("<h5 class='card-title' id='bemvindo'><i class='fas fa-user'></i> Bem-vindo, "+result.toString()+".</h5>");
              }

            })

            $('#registrarForm').submit(function(){
                var r_usuario=$('#r_usuario').val();
                var r_nome=$('#r_nome').val();
                var r_senha=$('#r_senha').val();
                var r_nivel=$('#r_nivel').val();

                $.ajax({
                    url: "../verificar.php",
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

                $.ajax({
                    url: "../verificar.php",
                    type: "post",
                    data: "l_nome="+l_nome+
                          "&l_codigo="+l_codigo+
                          "&l_barra="+l_barra+
                          "&l_link="+l_link+
                          "&l_estante="+l_estante+
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

            $('#alterarFormLivro').submit(function(){
                $('#erroAlterarLivro').hide();
                $('#errorProcurarLivro').hide();
                $('#certoAlterarLivro').hide();

                var c_livro=$('#c_livro').val();

                $.ajax({
                    url: "alterarLivro.php",
                    type: "post",
                    data: "c_livro="+c_livro+
                          "&verificar="+0,
                    success: function(result){
                        if(result == 0){
                            document.getElementById("aposProcurar").style.display = "none";
                            $('#errorProcurarLivro').show();
                            $('#erroAlterarLivro').hide();
                            $('#certoAlterarLivro').hide();

                        } else {
                            //document.getElementById("procurarLivro").style.display = "none";
                            $('#erroAlterarLivro').hide();
                            $('#errorProcurarLivro').hide();
                            $('#certoAlterarLivro').hide();

                            document.getElementById("aposProcurar").style.display = "block";
                            jQuery("#formularioDoLivro").html(result);
                            /*
                            if(result==0){
                                document.getElementById("certoAlterarLivro").style.display = "none";
                                document.getElementById("errorProcurarLivro").style.display = "block";
                            }*/

                        }
                    }
                })

                return false;
            })

            // alterarFormLivroX
            $('#alterarFormLivroX').submit(function(){
                var a_nome=$('#a_nome').val();
                var a_codigo=$('#a_codigo').val();
                var a_barra=$('#a_barra').val();
                var a_link=$('#a_link').val();
                var a_estante=$('#a_estante').val();
                var a_codigoAlterar=$('#a_codigoAlterar').val();

                $.ajax({
                    url: "alterarLivro.php",
                    type: "post",
                    data: "a_nome="+a_nome+
                          "&a_codigo="+a_codigo+
                          "&a_barra="+a_barra+
                          "&a_link="+a_link+
                          "&a_estante="+a_estante+
                          "&a_codigoAlterar="+a_codigoAlterar+
                          "&verificar="+1,
                    success: function(result){
                        if(result == 1){
                            $('#erroAlterarLivro').hide();
                            $('#errorProcurarLivro').hide();
                            $('#certoAlterarLivro').show();
                        } else {
                            $('#erroAlterarLivro').show();
                            $('#errorProcurarLivro').hide();
                            $('#certoAlterarLivro').hide();
                        }
                    }
                })

                return false;
            })

            $.ajax({
              url: "livrosPendentes.php",
              type: "post",
              data: "ativo="+1,
              success: function(result){
                 jQuery("#livrosPendentes").html(result);
              }

            })

            $('#alterarVisibilidade').submit(function(){
                var l_valor=$('#valor_l').val();
                var l_id=$('#id_l').val();

                $.ajax({
                    url: "livrosPendentes.php",
                    type: "post",
                    data: "ativo="+2+
                          "&l_valor="+l_valor+
                          "&l_id="+l_id,
                    success: function(result){
                      window.location.reload();
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
