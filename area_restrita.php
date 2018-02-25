<?php
    session_start();

    $executarFuncao = $_POST['executarFuncao'];

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
        
    if($login_check == 0){
        login_erro();
    }

    if(executarFuncao == 1){
        if($nivel>0){
            echo $nivel;
        }
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

    <div id="botoes" class="container-fluid" style="padding-top: 2%">
        <div id="botaoRegistrar">
            <button id="registrarUsuario" type="button" class="btn btn-dark">Registra Usuário</button>

            <div id="registrarUsuarioDiv">
                <center>
                <form style="padding-top: 5%; width: 35%;">
                    <h1>REGISTRAR USUÁRIO</h1>
                    <div class="form-group">
                        <label for="usuario">Usuário</label>
                        <input type="text" class="form-control" id="usuario" placeholder="Ex: maria">
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Ex: Maria">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="text" class="form-control" id="senha" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nível do usuário</label>
                        <input type="number" class="form-control" id="nivel" placeholder="Min: 1 ~ Max: 5" min="1" max="5">
                    </div>
               
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
                </center>
            </div>

        </div>
    </div>

    <div class="container-fluid footer text-light" style="text-align: center">
        UFPR Biblioteca PA
        
    </div>

    <script>
        $(document).ready(function(){
            $("#registrarUsuario").attr("disabled","disabled");
            $.ajax({
                url: "area_restrita.php",
                type: "post",
                data: "executarFuncao="+1,
                success: function(result){
                    if(result==5){
                        $("#registrarUsuario").attr("enable","enable");
                        
                    }
                }
            
            })
            
        })
        
        $("#registrarUsuario").click(function() {
            $("#registrarUsuarioDiv").css("display", "block");
        });
    </script>

</body>
</html>