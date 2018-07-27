<?php
    /*
      ** REMOVER ESTE ARQUIVO = NOVO ARQ. funcoesGerais.php **
    */
    session_start();

    include "cfg.php";
    include "funcoesGerais.php";

    $funcao = $_POST['executarFuncao'];

    $resultado = 0;

    switch ($funcao) {

      case 1: // RETORNA NÍVEL
        $user = $_SESSION['usuario'];
        $pass = $_SESSION['senha'];

        $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$user}' AND senha = '{$pass}'") or die (mysql_error());

        $dado = mysqli_fetch_array($sql);
        $resultado = $dado['nivel'];
        break;

      case 2: // REGISTRAR USUÁRIO
        $r_usuario = preg_replace('/[^a-z_]/', '',$_POST['r_usuario']);
        $r_senha = md5(preg_replace('/[^a-zA-Z0-9_]/', '',$_POST['r_senha']));
        $r_nome = preg_replace('/[^a-zA-Z\ _]/', '',$_POST['r_nome']);
        $r_nivel = preg_replace('/[^0-9_]/', '',$_POST['r_nivel']);
        $r_email = preg_replace('/[^a-zA-Z0-9@._\-_]/', '',$_POST['r_email']);

        if ((!$r_usuario) || (!$r_senha) || (!$r_nome) || (!$r_nivel) || (!$r_email) || $r_nivel == 0){
          $resultado = 0;
        } else {
          $sql_r = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario = '{$r_usuario}'") or die (mysql_error());
          $resultado_r = mysqli_num_rows($sql_r);

          if($resultado_r == 0){
            $registrar = mysqli_query($conectar, "INSERT INTO usuarios(usuario, nome, senha, nivel, email) VALUES ('$r_usuario', '$r_nome', '$r_senha', '$r_nivel', '$r_email')");
            gravar_log("Registrou usuário [".$r_usuario."] * [#126#]");
            $resultado = 1;
          }

        }
        break;

        case 3: // REGISTRAR LIVRO
          $l_nome = $_POST['l_nome'];
          $l_codigo = $_POST['l_codigo'];
          $l_barra = $_POST['l_barra'];
          $l_link = $_POST['l_link'];
          $l_estante = $_POST['l_estante'];
          $l_responsavel = $_SESSION['usuario'];

          if ((!$l_nome) || (!$l_barra) || (!$l_estante)|| (!$l_link) || (!$l_codigo)){
            $resultado = 0;
          } else {
            $sql_r = mysqli_query($conectar, "SELECT * FROM livros WHERE codigo = '{$l_codigo}'") or die (mysql_error());
            $resultado_r = mysqli_num_rows($sql_r);

            if($resultado_r == 0){
              $registrar = mysqli_query($conectar, "INSERT INTO livros(nome, codigo, barra, link, estante, responsavel) VALUES ('$l_nome', '$l_codigo', '$l_barra', '$l_link', '$l_estante', '$l_responsavel')");
              $resultado = 1;
            }

          }
          break;

        case 4: // RETORNA NOME

          $resultado = retornaNome();

          break;

        case 5: // VERIFICAR LOGIN
          if(verificarLogin(0)){
              $resultado = 1;
          } else {
              $resultado = 0;
          }

          break;

        case 6:
          $nivel = preg_replace('/[^0-9_]/', '',$_POST['nivel']);
          if(isset($nivel)){
              $resultado = verificarLogin($nivel);
          } else {
              $resultado = verificarLogin(0);
          }

      }


    echo $resultado;
    exit;
?>
