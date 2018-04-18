<?php

  include "../cfg.php";
  include "../funcoesGerais.php";

  $ano = $_POST["ano"];
  $dia = $_POST["dia"];
  $mes = $_POST["mes"];

  $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE ano='{$ano}' AND dia='{$dia}' AND mes='{$mes}'");

  if(verificarSql($sql)){
    if(verificarNivel(3)){ // ARRUMAR AQUI - PERMISSÕES ## ARRUMAR HTML

      if(isset($_POST["pegarCodigos"])){
        $codigos = mysqli_fetch_array($sql);
        echo "<textarea class='form-control' id='codigosAlterar' rows='10'>".$codigos['codigos']."</textarea><a id='iden'>".$codigos['id']."</a>";
      } elseif (isset($_POST["alterarCodigos"])) {
        $new_cod = $_POST["alterarCodigos"];
        $id = $_POST["iden"];

        mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$new_cod}' WHERE id='{$id}'");
      } else {
        echo "0 ERRO 1";
      }

    } else {
      echo "0 ERRO 2";
    }
  } else {
    echo "0 ERRO 3";
  }




?>
