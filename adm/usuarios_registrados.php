<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarNivel(5)){
    $sql = mysqli_query($conectar, "SELECT * FROM usuarios");
    if(verificarSql($sql)){
      printf("<table>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuario</th>
                    <th>Nível</th>
                    <th>E-Mail</th>
                  </tr>
                </thead> <tbody>");
      while($usuario = mysqli_fetch_array($sql)){
        printf("<tr>
                  <td>%d</td>
                  <td>%s</td>
                  <td>%s</td>
                  <td>%d</td>
                  <td>%s</td>
                </tr>", $usuario['id'], $usuario['nome'], $usuario['usuario'], $usuario['nivel'], $usuario['email']);
      }
      printf("</tbody> </table>");

      gravar_log("Consultou os usuários registrados * [113]");
    } else {
      echo 0;
    }
  } else {
    header("Location: ../error.html");
    exit;
  }

?>
