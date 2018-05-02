<?php
  session_start();

  include "../funcoesGerais.php";
  include "../cfg.php";

  $usuario = $_POST['usuario'];
  $senha = $_POST['senha'];
  $n_senha = $_POST['n_senha'];

  $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}' AND senha='{$senha}'");

  if(verificarSql($sql)){

  } else {
    echo 0;
  }

?>



/ CONTINUAR ESCREVER ESSE DOCUMENTO
