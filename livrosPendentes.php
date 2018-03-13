<?php
  session_start();

  include "cfg.php";

  $ativo = $_POST['ativo'];

  if($ativo == 1){
    quantidade($conectar);
  }

  if($ativo == 2){
    $valor = $_POST['l_valor'];

    alterar($valor, $conectar);
  }


  function quantidade($conectar){

    $sql = mysqli_query($conectar, "SELECT id, nome, barra, estante, responsavel, link, codigo FROM livros WHERE ativo = '0' ORDER BY id");

    $livros_check = mysqli_num_rows($sql);

    if($livros_check == 0){
      printf("<h5 class='card-text'><i class='fas fa-check' style='color: #9ef442'></i> <b>NENHUM LIVRO ESPERANDO SER ATIVADO!</b></h5>");

    } else {

      while ($dado = mysqli_fetch_array($sql)) {
        printf("

                <div class='card'>
                  <div class='card-body'>

                    <p class='card-text'><i class='fas fa-book'></i> <b>Nome:</b> %s</p>
                    <p class='card-text'><i class='fas fa-map-marker'></i> <b>Chamada:</b> %s</p>
                    <p class='card-text'><i class='fas fa-location-arrow'></i> <b>Prateleira:</b> %s</p>
                    <p class='card-text'><i class='fas fa-user'></i> <b>Responsável:</b> %s</p>
                    <p class='card-text'><i class='fas fa-link'></i> <b>Link:</b> <a href='%s' target='_blank'>Ir para página</a></p>
                    <p class='card-text'><i class='fas fa-qrcode'></i> <b>Codigo:</b> %s</p>
                    <p class='card-text'><i class='fas fa-id-card' style='color: #B00B0B'></i> <b>ID:</b> %d</p>


                  </div>
                </div>

                ", $dado['nome'], $dado['barra'], $dado['estante'], $dado['responsavel'], $dado['link'], $dado['codigo'], $dado['id']);

      }

    }
  }

  function alterar($valor, $conectar){
    $id_livro = $_POST['l_id'];

    $sql = mysqli_query($conectar, "SELECT * FROM livros WHERE id='{$id_livro}'") or die (mysql_error());
    $livro_check = mysqli_num_rows($sql);

    if($livro_check == 1){
      switch ($valor) {
        case 1:
          mysqli_query($conectar, "UPDATE `livros` SET `ativo` = '1' WHERE `livros`.`id` = '{$id_livro}'");
          break;

        case 2:
          mysqli_query($conectar, "DELETE FROM `livros` WHERE `livros`.`id` = '{$id_livro}'");
          break;

      }
    }
  }

?>
