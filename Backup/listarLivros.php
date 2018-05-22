<?php

  include "cfg.php";

  $sql = mysqli_query($conectar, "SELECT nome, barra, estante, link, codigo FROM livros ORDER BY id");

  $livros_check = mysqli_num_rows($sql);

  if($livros_check <= 0){
    printf("<h1>NENHUM LIVRO REGISTRADO!</h1>");
  } else {
    while ($dado = mysqli_fetch_array($sql)) {
      printf("
              <p><b>Nome:</b> %s | <b>Chamada:</b> %s | <b>Estante:</b> %s | <b>Link:</b> %s | <b>Codigo:</b> %s</p>
      ", $dado['nome'], $dado['barra'], $dado['estante'], $dado['link'], $dado['codigo']);
    }
  }

?>
