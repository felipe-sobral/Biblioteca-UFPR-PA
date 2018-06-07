<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarNivel(3)){

    if(isset($_POST["pegarCodigos"])){

      $ano = $_POST["ano"];
      $dia = $_POST["dia"];
      $mes = $_POST["mes"];

      $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE ano='{$ano}' AND dia='{$dia}' AND mes='{$mes}'");

      if(verificarSql($sql)){
        $dado = mysqli_fetch_array($sql);

        echo "<textarea id='codigosAlterar' class='materialize-textarea'>".$dado['codigos']."</textarea><script>var iden=".$dado['id']."; M.textareaAutoResize($('#codigosAlterar'));</script>";
      } else {
        echo "0";
      }

    } elseif (isset($_POST["alterarCodigos"])) {
      $id = $_POST["iden"];

      if($_POST["alterarCodigos"] != null){
        $inserir = str_replace('<br />', '\r', nl2br($_POST["alterarCodigos"]));
        mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$inserir}' WHERE id='{$id}'");
        gravar_log("Alterou Consulta Local [ID:".$id."] * [115]");
      }else{
        mysqli_query($conectar, "DELETE FROM consulta_local WHERE id='{$id}'");
        gravar_log("Excluiu Consulta Local [ID:".$id."] * [116]");
      }

      echo "1";

    } else {
      echo "0";

    }

  } else {
    echo "0";

  }

?>
