<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";
  include "inserir_funcao.php";

  if(verificarNivel(3)){
    $codigo = $_POST['codigoBarras'];
    if(inserirCodigo($codigo) == true){
        echo 1;
    } else {
        echo 0;
    }
  }


?>
