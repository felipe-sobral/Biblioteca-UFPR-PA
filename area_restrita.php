<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Biblioteca UFPR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/main.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php
	    session_start();
	    include "cfg.php";
	
	    $usuario = $_SESSION['usuario'];
	    $senha = $_SESSION['senha'];
	    $nivel = $_SESSION['nivel'];
	    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'");
        $login_check = mysqli_num_rows($sql);
        
	    if($login_check == 0){
            header("Location: login.html");
        }

    ?>


    <div class="container-fluid cabecalho">
        <h1 style="filter: invert();">BIBLIOTECA UFPR</h1>
    </div>

    <h2>Bem vindo a área restrita!!!</h2>

    <div class="container-fluid espacoLogin">
    <a href="login.html"><button class="btn btn-dark btn-sm">Sair</button></a>
        
    </div>

</body>
</html>