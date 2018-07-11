<?php
  session_start();

  /*

    IDEIA

      DB TAREFAS
        TABLE $USUARIO -> CASO NÃO EXISTA -> CRIA TABELA COM A ESTRUTURA -> INSERE TAREFA
                          CASO EXISTA -> INSERE TAREFA

      ESTRUTURA DA TABELA
        id INT(6) PRIMARY_KEY AUTO_INCREMENT
        usr_id INT(6)
        titulo VARCHAR(100)
        descricao VARCHAR(1000)
        t_status BIT
        data_registro VARCHAR(12)
        data_final VARCHAR(12)

      INSERT INTO $USUARIO(usr_id, `usr_id`, `nome`, `descricao`, `t_status`, `data_registro`, `data_final`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
      CREATE TABLE tarefas(..., ..., ..., ..., ...);

  */

  include "cfg2.php";
  include "../cfg.php";
  include "../funcoesGerais.php";

  function criaTarefa($id, $titulo, $descricao){
    $data = date("d/m/Y");

    //mysqli_query($GLOBALS['conectar'], "INSERT INTO tarefas(usr_id, nome, descricao, t_status, data_registro) VALUES ('{$id}', '{$titulo}', '{$descricao}', 1, '{$data}')");
  }

  if(verificarNivel(1)){
    $usuario = retornaID($_POST['t_usuario']);

    if(($usuario != $_SESSION['id']) && verificarNivel(4)){
      criaTarefa($usuario, $_POST['t_titulo'], $_POST['t_descricao']);
      echo 1;
      exit;
    } elseif ($usuario == $_SESSION['id']){
      criaTarefa($usuario, $_POST['t_titulo'], $_POST['t_descricao']);
      echo 1;
      exit;
    } else {
      echo 0;
      exit;
    }
  }

?>
