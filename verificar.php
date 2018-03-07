<?php
    session_start();

    include "cfg.php";

    $funcao = $_POST['executarFuncao'];

    $resultado = 0;

    if($funcao == 1){ // RETORNA NÍVEL
        $user = $_SESSION['usuario'];
        $pass = $_SESSION['senha'];

        $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$user}' AND senha = '{$pass}'") or die (mysql_error());

        $dado = mysqli_fetch_array($sql);
        $resultado = $dado['nivel'];
    }

    if($funcao == 2){ // PARA CADASTRAR USUÁRIO
        $r_usuario = $_POST['r_usuario'];
        $r_senha = $_POST['r_senha'];
        $r_nome = $_POST['r_nome'];
        $r_nivel = $_POST['r_nivel'];

        if ((!$r_usuario) || (!$r_senha) || (!$r_nome) || (!$r_nivel)){
          $resultado = 0;
        } else {
          $sql_r = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$r_usuario}'") or die (mysql_error());
          $resultado_r = mysqli_num_rows($sql_r);

          if($resultado_r == 0){
            $registrar = mysqli_query($conectar, "INSERT INTO usuarios(usuario, nome, senha, nivel) VALUES ('$r_usuario', '$r_nome', '$r_senha', '$r_nivel')");
            $resultado = 1;
          }

        }

    }

    if($funcao == 3){ // PARA CADASTRAR LIVRO
        $l_nome = $_POST['l_nome'];
        $l_codigo = $_POST['l_codigo'];
        $l_barra = $_POST['l_barra'];
        $l_link = $_POST['l_link'];
        $l_estante = $_POST['l_estante'];
        $l_responsavel = $_SESSION['usuario'];
        $l_ativo = $_POST['l_ativo'];


        if ((!$l_nome) || (!$l_barra) || (!$l_estante) || (!$l_ativo) || (!$l_link) || (!$l_codigo)){
          $resultado = 0;
        } else {
          $sql_r = mysqli_query($conectar, "SELECT * FROM livros WHERE codigo = '{$l_codigo}'") or die (mysql_error());
          $resultado_r = mysqli_num_rows($sql_r);

          if($resultado_r == 0){
            $registrar = mysqli_query($conectar, "INSERT INTO livros(nome, codigo, barra, link, estante, responsavel, ativo) VALUES ('$l_nome', '$l_codigo', '$l_barra', '$l_link', '$l_estante', '$l_responsavel', '$l_ativo')");
            $resultado = 1;
          }

        }

    }

    if($funcao == 4){ // RETORNA NOME

      if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$usuario}'") or die(mysql_error());

        $dado = mysqli_fetch_array($sql);

        $resultado = $dado['nome'];

      }

    }

    if($funcao == 5){ // VERIFICAR SE JÁ TEM SESSÃO
      if(isset($_SESSION['usuario'])){
        $resultado = 1;
      }
    }

    echo $resultado;
    exit;
?>
