<?php
  session_start();

  include "cfg2.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  // 0 = CONCLUIR | 1 = EXCLUIR
  $id = $_POST['id'];
  $sql = mysqli_query($conectar2, "SELECT * FROM ".$_SESSION['usuario']." WHERE id='{$id}'");
  if(verificarSql($sql)){

    if($_POST['funcao'] == 0){
      $data = date("d/m/Y");
      mysqli_query($conectar2, "UPDATE ".$_SESSION['usuario']." SET t_status=0, data_final='{$data}' WHERE id='{$id}'");
      echo 1;
      exit;
    }

    if($_POST['funcao'] == 1){
      mysqli_query($conectar2, "DELETE FROM ".$_SESSION['usuario']." WHERE id='{$id}'");
      echo 1;
      exit;
    }


  } else {
    echo 0;
  }

?>
