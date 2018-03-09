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
        printf("
                <p>-----</p>
                <p>Nome: %s </p>
                <p>Barra: %s </p>
                <p>Link: %s </p>
                <p>Codigo: %s </p>
                <p>-----</p>

                ", $dado['nome'], $dado['barra'], $dado['link'], $dado['codigo']);

      }

    }


  }

?>
