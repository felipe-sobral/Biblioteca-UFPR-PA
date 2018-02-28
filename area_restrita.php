<?php
    /*

      NOTAS:

      ** Arrumar o porquê que a janela não está sendo exibida no botão "REGISTRAR LIVRO"

      ** ACRESCENTAR ESTILO PARA ALINHAR BOTÕES OU BUSCAR OUTRO MEIO (EXEMPLO: NAVBAR)

      ** COLOCAR NOME DOS LIVROS QUANDO ACHADOS NO INDEX

      ** CONFIRMAR PRATELEIRA DO ITEM "2" DO BANCO DE DADOS (LIVROS) - Histologia básica - 611.018 J95 11.ed

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


    <!-- BOTÕES -->
    <div id="botoes" class="container-fluid" style="padding-top: 2%">
        <!-- BOTÃO PARA CADASTRAR USUÁRIO | NÍVEL 5 -->
        <div id="botaoRegistrar">
            <button id="registrarUsuario" type="button" class="btn btn-dark">Registrar Usuário</button>

            <div id="registrarUsuarioDiv">
                <center>
                <form id="registrarForm" style="padding-top: 5%; width: 35%;">
                    <div id="erroRegistrar" class="alert alert-danger" role="alert">
                        <b>Algo está errado</b>. O usuário já existe ou campos estão vazios!
                    </div>
                    <div id="registroRealizado" class="alert alert-success" role="alert">
                        <b>Usuário cadastrado!</b> Para fechar esta janela clique em <b>cancelar</b>
                    </div>

                    <h1>REGISTRAR USUÁRIO</h1>
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
                        <input type="text" class="form-control" id="r_senha" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nível do usuário</label>
                        <input type="number" class="form-control" id="r_nivel" placeholder="Min: 1 ~ Max: 5" min="1" max="5">
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="button" id="cancel" class="btn btn-danger">Cancelar</button>
                </form>
                </center>
            </div>
        </div>
        <!-- BOTÃO PARA CADASTRAR USUÁRIO | NÍVEL 5 | FIM -->

        <!-- BOTÃO PARA CADASTRAR LIVRO | NÍVEL 1 -->
        <div id="botaoRegistrarLivro">
            <button id="registrarLivro" type="button" class="btn btn-dark">Registrar Livro</button>

            <div id="registrarLivroDiv">
                <center>
                <form id="registrarFormLivro" style="padding-top: 5%; width: 35%;">
                    <div id="erroRegistrarLivro" class="alert alert-danger" role="alert">
                        <b>Algo está errado</b>. O livro já foi cadastrado ou campos estão vazios!
                    </div>
                    <div id="registroRealizadoLivro" class="alert alert-success" role="alert">
                        <b>Livro cadastrado!</b> Para fechar esta janela clique em <b>cancelar</b>
                    </div>

                    <h1>REGISTRAR LIVRO</h1>
                    <div class="form-group">
                        <label for="l_nome">Nome</label>
                        <input type="text" class="form-control" id="l_nome" placeholder="Ex: Manual de normalização de documentos científicos">
                    </div>
                    <div class="form-group">
                        <label for="l_barra">Endereço</label>
                        <input type="text" class="form-control" id="l_barra" placeholder="Ex: 001.8 M294">
                    </div>
                    <div class="form-group">
                        <label for="l_estante">Estante</label>
                        <input type="text" class="form-control" id="l_estante" placeholder="Ex: 1A">
                    </div>
                    <div class="form-group">
                        <label for="l_ativo">Ativo (0 = NÃO | 1 = SIM)</label>
                        <input type="number" class="form-control" id="r_nivel" placeholder="Min: 0 ~ Max: 1" min="0" max="1">
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="button" id="cancel" class="btn btn-danger">Cancelar</button>
                </form>
                </center>
            </div>
          </div>
        <!-- BOTÃO PARA CADASTRAR LIVRO | NÍVEL 1 | FIM -->

    </div>




    <div class="container-fluid footer text-light" style="text-align: center">
        UFPR Biblioteca PA

    </div>

    <script>
        $(document).ready(function(){
            $('#registrarUsuario').prop('disabled', true);
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
                      $("#registrarUsuario").prop('disabled', false);
                    }
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
                var l_barra=$('#l_barra').val();
                var l_estante=$('#l_estante').val();
                var l_ativo=$('#l_ativo').val();

                $.ajax({
                    url: "verificar.php",
                    type: "post",
                    data: "l_nome="+l_nome+
                          "&l_barra="+l_barra+
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

        $("#registrarUsuario").click(function() {
            $("#registrarUsuarioDiv").css("display", "block");
        });

        $("#registrarLivro").click(function() {
            $("#registrarLivroDiv").css("display", "block");
        });

        $("#registrarUsuarioDiv #cancel").click(function() {
            $(this).parent().parent().parent().hide();
        });

        $("#registrarLivroDiv #cancel").click(function() {
            $(this).parent().parent().parent().hide();
        });
    </script>

</body>
</html>
