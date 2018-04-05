<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";
  include "inserir_funcao.php";

  if(verificarNivel(3)){
    $codigo = $_POST['codigoBarras'];
    inserirCodigo($codigo);
  }


?>
