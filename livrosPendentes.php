<?php
  session_start();

  include "cfg.php";

  $ativo = $_POST['ativo'];

  if($ativo){
    quantidade($conectar);
  }

  function quantidade($conectar){

    $sql = mysqli_query($conectar, "SELECT id, nome, barra, link, codigo FROM livros WHERE ativo = '0' ORDER BY id");

    $livros_check = mysqli_num_rows($sql);

    if($livros_check == 0){
        echo "NENHUM LIVRO ESPERANDO SER ATIVADO!";
    } else {

      while ($dado = mysqli_fetch_array($sql)) {
        printf("<p>-----</p>");
        printf("<p>Nome: %s </p>", $dado['nome']);
        printf("<p>Barra: %s </p>", $dado['barra']);
        printf("<p>Link: %s </p>", $dado['link']);
        printf("<p>Codigo: %s </p>", $dado['codigo']);
        printf("<p>-----</p>");

      }

    }


  }

?>
