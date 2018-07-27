<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarLogin(5)){
    $usr = preg_replace('/[^a-z_]/', '',$_POST['log_usuario']);

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usr}'");
    if(verificarSql($sql)){
      $dados = mysqli_fetch_array($sql);
      $dado_log = nl2br($dados['log']);

      gravar_log("Exibiu log do usuário [ID:".$dados['id']."] * [#127#]");
      echo $dado_log;
    }else{
      echo 0;
      //error();
    }
  } else {
    echo 0;
    //error();
  }
?>
