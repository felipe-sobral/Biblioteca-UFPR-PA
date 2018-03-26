<?php

  /* if(!isset($_SESSION)){
    session_start();
  }

  include "cfg.php"; */

  function verificarNivel($nivel){
    if(isset($_SESSION)){
      if($_SESSION['nivel'] >= $nivel){
        return true;
      } else {
        return false;
      }
    }
  }

  function verificarSql($sql){
    $v_sql = mysqli_num_rows($sql);
    if($v_sql>0){
      return true;
    } else {
      return false;
    }
  }

  function retornaNome(){
    if(isset($_SESSION['usuario'])){
      $usuario = $_SESSION['usuario'];
      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM usuarios WHERE usuario = '{$usuario}'") or die(mysql_error());

      $dado = mysqli_fetch_array($sql);

      return $dado['nome'];

    }
  }

?>
