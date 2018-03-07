<?php
  session_start();

  include "cfg.php";

  $ativo = $_POST['ativo'];

  if($ativo){
    quantidade();
  }

  function quantidade(){

    $tamanho = mysqli_query($conectar, "SELECT COUNT(ativo) FROM livros");

    for ($i=0; $i <= $tamanho ; $i++) {
      $sql = mysqli_query($conectar, "SELECT * FROM livros WHERE ativo='{1}'");
      $ativo_check = mysqli_num_rows($sql);

      if($ativo_check != 1){
          $dado = mysqli_fetch_array($sql);

          echo "<p>=================</p>";
          echo "<p>Nome: "+$_dado['nome']+"</p>";
          echo "<p>Barra: "+$_dado['barra']+"</p>";
          echo "<p>Link: "+$_dado['link']+"</p>";
          echo "<p>Codigo: "+$_dado['codigo']+"</p>";
          echo "<p>=================</p>";
      }
    }


  }

?>
