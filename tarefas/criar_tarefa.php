<?php
  session_start();

  include "cfg2.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  function criaTarefa($usuario, $titulo, $descricao){
    $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
    if(verificarSql($sql)){
      mysqli_query($GLOBALS['conectar2'], "CREATE TABLE IF NOT EXISTS ".$usuario."(id INT(6) PRIMARY KEY AUTO_INCREMENT, usr_id INT(6), titulo VARCHAR(100), descricao VARCHAR(1000), t_status BIT, data_registro VARCHAR(12), data_final VARCHAR(12))");
      $data = date("d/m/Y");
      $id = retornaID($usuario);
      mysqli_query($GLOBALS['conectar2'], "INSERT INTO ".$usuario."(usr_id, titulo, descricao, t_status, data_registro) VALUES ('{$id}', '{$titulo}', '{$descricao}', 1, '{$data}')");
    } else {
      echo 0;
      exit;
    }
  }

  if(verificarNivel(1)){

    if(($_POST['t_usuario'] != $_SESSION['id']) && verificarNivel(4)){
      criaTarefa($_POST['t_usuario'], $_POST['t_titulo'], $_POST['t_descricao']);
      echo 1;
      exit;
    } elseif ($_POST['t_usuario'] == $_SESSION['id']){
      criaTarefa($_POST['t_usuario'], $_POST['t_titulo'], $_POST['t_descricao']);
      echo 1;
      exit;
    } else {
      echo 0;
      exit;
    }
  }

?>
