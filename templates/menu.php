<?php

printf("
<li>
  <ul class='collapsible collapsible-accordion'>
    <li>
      <a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;'><i class='material-icons'>people</i>Estatística de Usuários</a>
      <div class='collapsible-body'>
        <ul>
          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/painel.html'>Contador</a></li>
          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/adicionar.html'>Adicionar</a></li>
          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/historico.html'>Histórico</a></li>
          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/alterar.html'>Alterar</a></li>
          <li><div class='divider'></div></li>
        </ul>
      </div>
    </li>
  </ul>
</li>

<li>
  <ul class='collapsible collapsible-accordion'>
    <li>
      <a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;'><i class='material-icons'>assignment_turned_in</i>Estatística Consulta Local</a>
      <div class='collapsible-body'>
        <ul>
          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/registrar_codigos.html'>Registrar códigos</a></li>
          <li><a class='waves-effect' style='text-decoration:none'>Adicionar</a></li>
          <li><a class='waves-effect' style='text-decoration:none'>Histórico</a></li>
          <li><a class='waves-effect' style='text-decoration:none'>Alterar</a></li>
          <li><a class='waves-effect' style='text-decoration:none'>Baixar</a></li>
          <li><div class='divider'></div></li>
        </ul>
      </div>
    </li>
  </ul>
</li>

<li>
  <ul class='collapsible collapsible-accordion'>
    <li>
      <a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;'><i class='material-icons'>settings</i>Gerenciar conta</a>
      <div class='collapsible-body'>
        <ul>
          <li><a class='waves-effect' style='text-decoration:none'>Alterar senha</a></li>
          <li><a class='waves-effect' style='text-decoration:none'>Excluir conta</a></li>
          <li><div class='divider'></div></li>
        </ul>
      </div>
    </li>
  </ul>
</li>

<li><a class='collapsible-header waves-effect waves-yellow' style='text-decoration:none'><i class='material-icons'>lock</i>Administração</a></li>
<li><a class='collapsible-header waves-effect waves-red' style='text-decoration:none' href='../logout.php'><i class='material-icons'>exit_to_app</i>Sair</a></li>

</ul>

<img src='../img/branco_UFPR.png' style='bottom: 0; position: absolute;'/>
<script>$('.collapsible').collapsible();");

?>
