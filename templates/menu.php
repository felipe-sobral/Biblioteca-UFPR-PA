<?php
	session_start();

	include "../cfg.php";
	include "../funcoesGerais.php";
	
	$nome = retornaNome();

	printf("
	<li><div class='user-view'>
		<div class='background'>
    	<img src='../img/bg.jpg'>
    </div>
	  <center><a href='http://bibliotecaufprpa.hol.es/home_restrita.html'><img src='../img/branco_UFPR.png' width='188vh'></a>
	  <h5 id='nomeID' class='card-title text-light'>%s</h5>
		<hr width='200vh''/>
	</div></li>
	<li><a class='collapsible-header waves-effect' style='text-decoration:none' href='../contador_usuario/painel.html'><i class='material-icons'>star_rate</i>Contador de usuários</a></li>
	<li><a class='collapsible-header waves-effect' style='text-decoration:none' href='../consulta_local/registrar_codigos.html'><i class='material-icons'>star_rate</i>Registrador consulta local</a></li>
	<hr width='200vh''/>
	<li>
	  <ul class='collapsible collapsible-accordion'>
	    <li>
	      <a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;'><i class='material-icons'>people</i>Estatística de Usuários</a>
	      <div class='collapsible-body'>
	        <ul>
	          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/painel.html'><i class='material-icons'>group_add</i>Contador</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/adicionar.html'><i class='material-icons'>add</i>Adicionar</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/historico.html'><i class='material-icons'>history</i>Histórico</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../contador_usuario/alterar.html'><i class='material-icons'>edit</i>Alterar</a></li>
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
	          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/registrar_codigos.html'><i class='material-icons'>note_add</i>Registrar códigos</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/adicionar.html'><i class='material-icons'>add</i>Adicionar</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/historico.html'><i class='material-icons'>history</i>Histórico</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/alterar.html'><i class='material-icons'>edit</i>Alterar</a></li>
	          <li><a class='waves-effect' style='text-decoration:none' href='../consulta_local/baixar.html'><i class='material-icons'>cloud_download</i>Baixar</a></li>
	          <li><div class='divider'></div></li>
	        </ul>
	      </div>
	    </li>
	  </ul>
	</li>


	<li><a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;' href='../gerenciar_conta/painel.html'><i class='material-icons'>settings</i>Gerenciar conta</a></li>
	<li><a class='collapsible-header waves-effect waves-yellow' style='text-decoration:none' href='../adm/painel.html'><i class='material-icons'>lock</i>Administração</a></li>
	<li><a class='collapsible-header waves-effect' style='text-decoration:none' href='https://goo.gl/forms/QvhPwxZpUs0IT1Ys1' target='_blank'><i class='material-icons'>bug_report</i>Reportar<i class='material-icons right'>new_releases</i></a></li>
	<li><a class='collapsible-header waves-effect waves-red' style='text-decoration:none' href='../logout.php'><i class='material-icons'>exit_to_app</i>Sair</a></li>
	<li><a class='collapsible-header waves-effect waves-orange' style='text-decoration:none'></li>

	</ul>
	<div style='padding-bottom: 2vh'></div>

	<script>$('.collapsible').collapsible();", $nome);
?>
