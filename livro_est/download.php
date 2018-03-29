<?php

  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  function gravar($codigos, $nomeArquivo){
    $endereco = "/downloads"."/".$nomeArquivo.".txt";

    $abrir = fopen($endereco, "a+");

    fwrite($abrir, $codigos);

    fclose($abrir);

  }

  gravar("Deu certo!!");

  // CONTINUAR DAQUI

?>
