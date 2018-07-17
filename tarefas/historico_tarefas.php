<?php
  session_start();

  include "cfg2.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  $usuario = $_SESSION['usuario'];

  function imprimir_linha($id, $titulo, $criada, $finalizada, $status){
    if($status == 1){
      $st = "<i class='material-icons'>timer</i>";
    } else {
      $st = "<i class='material-icons' style='color: #42f47d'>done</i>";
    }

    printf("
    <tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
    </tr>
    ", $id, $titulo, $criada, $finalizada, $st);
  }

  echo "<table class='responsive-table highlight'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Criada</th>
        <th>Finalizada</th>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>";

  if($sql_v = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'")){
    if($sql_tarefas = mysqli_query($conectar2, "SELECT * FROM ".$usuario."")){
      $tb_linhas = mysqli_num_rows($sql_tarefas);
      if($tb_linhas>0){
        while($tarefa = mysqli_fetch_array($sql_tarefas)){
          imprimir_linha($tarefa['id'], $tarefa['titulo'], $tarefa['data_registro'], $tarefa['data_final'], $tarefa['t_status']);
        }

        echo "</tbody></table>";
      }
    } else {
      echo 0;
      exit;
    }
  } else {
    echo 0;
    exit;
  }

?>
