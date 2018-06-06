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
    if($v_sql != null){
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

  function retornaData($sql_retorno){
    $resultado = mysqli_fetch_row($sql_retorno);
    $resultado = $resultado[0];

    return $resultado;
  }

  function verificarLogin($nivel){
    if(isset($_SESSION['usuario'])){

      $usuario = $_SESSION['usuario'];
      $senha = $_SESSION['senha'];
      $u_nivel = $_SESSION['nivel'];

      if($u_nivel >= $nivel){
        $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM usuarios WHERE usuario='{$usuario}' AND senha='{$senha}'");
        if(verificarSql($sql)){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }

    } else {
      return false;
    }
  }

  function gravar_log($mensagem){
    if($_SESSION){
      $id = $_SESSION['id'];
      $ip = $_SERVER['REMOTE_ADDR'];
      $usr = "[".$ip."][".date("Y-m-d H:i:s")."]";

      $text = $usr." - ".$mensagem;

      $sql = mysqli_query($GLOBALS['conectar'], "SELECT * FROM usuarios WHERE id='{$id}'");
      $dado = mysqli_fetch_array($sql);

      $full_mensagem = $dado['log']."\r\n".$text;

      mysqli_query($GLOBALS['conectar'], "UPDATE usuarios SET log='{$full_mensagem}' WHERE id='{$id}'");
    }
  }

?>
