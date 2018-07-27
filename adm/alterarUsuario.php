<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(!verificarLogin(5)){
    echo "SEM PERMISSÃO!";
    exit;
  }

  if(isset($_POST['fn']) && $_POST['fn']==1){
    $usuario = preg_replace('/[^a-z_]/', '',$_POST['$alterarUser_usuario']);

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
    $resultado = verificarSql($sql);

    if($resultado){
      $dados = mysqli_fetch_array($sql);

      printf("

        <script>var usuarioUsuario = '%s';</script>
        <script>var nomeUsuario = '%s';</script>
        <script>var alterarUser_id = %d;</script>
        <script>var nivelUsuario = %d;</script>
        <script>var emailUsuario = '%s';</script>

      ", $dados['usuario'], $dados['nome'], $dados['id'], $dados['nivel'], $dados['email']);
      exit;
    } else {
      echo 0;
      exit;
    }
  }

  if(isset($_POST['fn']) && $_POST['fn']==2){
    $verificarA = $_POST['alterarUser_alterar'];

    if($verificarA == 1){
      $usuario = preg_replace('/[^a-z_]/', '',$_POST['alterarUser_usuario2']);
      $id = preg_replace('/[^0-9_]/', '',$_POST['alterarUser_id']);
      $nome = preg_replace('/[^a-zA-Z\ _]/', '',$_POST['alterarUser_nome']);
      $senha = md5(preg_replace('/[^a-zA-Z0-9_]/', '',$_POST['alterarUser_senha']));
      $nivel = preg_replace('/[^0-9_]/', '',$_POST['alterarUser_nivel']);
      $email = preg_replace('/[^a-zA-Z0-9@._\-_]/', '',$_POST['alterarUser_email']);

      $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE id='{$id}'");
      if(verificarSql($sql)){
        $v_sql = mysqli_num_rows($sql);
        if($v_sql == 1){
          if((!$usuario) || (!$id) || (!$nome) || (!$email) || ($nivel==0)){
            echo 0;
            exit;
          } else {
            if($senha != null){
              mysqli_query($conectar, "UPDATE usuarios SET usuario='{$usuario}', nome='{$nome}', senha='{$senha}', nivel='{$nivel}', email='{$email}' WHERE id='{$id}'");
            } else {
              mysqli_query($conectar, "UPDATE usuarios SET usuario='{$usuario}', nome='{$nome}', nivel='{$nivel}', email='{$email}' WHERE id='{$id}'");
            }
          }
          gravar_log("Alterou o usuário [ID:".$id."] * [#111#]");
          echo 1;
          exit;
        }
        echo 0;
        exit;
      }
    }

    if($verificarA == 2) {
      $usuario = preg_replace('/[^a-z_]/', '',$_POST['alterarUser_usuario2']);
      $id = preg_replace('/[^0-9_]/', '',$_POST['alterarUser_id']);
      $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
      if(verificarSql($sql)){
        mysqli_query($conectar, "DELETE FROM usuarios WHERE id='{$id}'");

        gravar_log("Deletou o usuário [ID:".$id."][".$usuario."] * [#112#]");
        echo 1;
        exit;
      }

      echo 0;
      exit;
    }

  } else {
    echo 0;
    exit;
  }

  echo "MÉTODO DE INJEÇÃO INVÁLIDO";
  exit;

?>
