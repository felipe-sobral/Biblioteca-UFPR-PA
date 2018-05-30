<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(!verificarLogin(5)){
    echo "SEM PERMISSÃO!";
    exit;
  }

  if(isset($_POST['fn']) && $_POST['fn']==1){
    $usuario = $_POST['$alterarUser_usuario'];

    $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
    $resultado = verificarSql($sql);

    if($resultado){
      $dados = mysqli_fetch_array($sql);

      printf("
        <div class='row'>
          <div class='input-field col s6'>
            <input id='alterarUser_usuario2' maxlength='10' type='text' value='%s'></input>
            <span class='helper-text'>Usuário|Máximo 10 caracteres.</span>
          </div>
          <div class='input-field col s6'>
            <input id='alterarUser_nome' value='%s' maxlength='60' type='text'></input>
            <span class='helper-text'>Nome|Máximo 60 caracteres.</span>
          </div>
        </div>
        <div class='row'>
          <div class='input-field col s6'>
            <input id='alterarUser_senha' placeholder='Senha' maxlength='10' type='password'></input>
            <span class='helper-text'>Senha|Máximo 10 caracteres.</span>
          </div> // CONTINUAAAAAAAAAAAAAAAAAAAAAAAAAR AQUI
          <div class="input-field col s6">
            <select id="r_nivel">
              <option selected disabled>Nível do usuário</option>
              <option value="1">[1] Registrado</option>
              <option value="2">[2] Provisório</option>
              <option value="3">[3] Comum</option>
              <option value="4">[4] Moderador</option>
              <option value="5">[5] Administrador</option>
            </select>
            <label for="r_senha">Nível atual</label>
          </div>
        </div>

        <div class='form-group'>
          <label for='senha'>Senha <small class='text-muted'>Máximo de caracteres: 10</small></label>
          <input type='password' maxlength='10' class='form-control' >
        </div>
        <div class='form-group'>
          <label for='nivel'>Nível do usuário (Atual: %s)</label>
          <select class='form-control' id='alterarUser_nivel'>
            <option value='1'>[1] Registrado</option>
            <option value='2'>[2] Provisório</option>
            <option value='3'>[3] Comum</option>
            <option value='4'>[4] Moderador</option>
            <option value='5'>[5] Administrador</option>
          </select>
        </div>

        <div class='form-group'>
          <label for='nivel'>O que fazer?</label>
          <select class='form-control' id='alterarUser_alterar'>
            <option value='1'>Apenas alterar</option>
            <option value='2'>Excluir conta</option>
          </select>
        </div>

        <input id='alterarUser_id' value='%d' style='display: none;'>

      ", $dados['usuario'], $dados['nome'], $dados['nivel'], $dados['id']);
      exit;
    } else {
      echo 0;
      exit;
    }
  }

  if(isset($_POST['fn']) && $_POST['fn']==2){
    $verificarA = $_POST['$alterarUser_alterar'];

    if($verificarA == 1){
      $usuario = $_POST['$alterarUser_usuario2'];
      $id = $_POST['$alterarUser_id'];
      $nome = $_POST['$alterarUser_nome'];
      $senha = $_POST['$alterarUser_senha'];
      $nivel = $_POST['$alterarUser_nivel'];

      $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
      if(verificarSql($sql)){
        $v_sql = mysqli_num_rows($sql);
        if($v_sql == 1){
          if($senha != null){
            mysqli_query($conectar, "UPDATE usuarios SET usuario='{$usuario}', nome='{$nome}', senha='{$senha}', nivel='{$nivel}' WHERE id='{$id}'");
          } else {
            mysqli_query($conectar, "UPDATE usuarios SET usuario='{$usuario}', nome='{$nome}', nivel='{$nivel}' WHERE id='{$id}'");
          }

          echo 1;
          exit;
        }
        echo 0;
        exit;
      }
    }

    if($verificarA == 2) {
      $usuario = $_POST['$alterarUser_usuario2'];
      $id = $_POST['$alterarUser_id'];
      $sql = mysqli_query($conectar, "SELECT * FROM usuarios WHERE usuario='{$usuario}'");
      if(verificarSql($sql)){
        mysqli_query($conectar, "DELETE FROM usuarios WHERE id='{$id}'");
        echo 1;
        exit;
      }

      echo 0;
      exit;
    }

    echo 0;
    exit;
  } else {
    echo 0;
    exit;
  }

  echo "MÉTODO DE INJEÇÃO INVÁLIDO";
  exit;

?>
