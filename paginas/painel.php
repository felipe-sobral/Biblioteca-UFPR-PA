<?php
   require "../root/init.php";

   session_start();
 
   if(acesso_restrito(2)){
      $cabecalho = file_get_contents('../root/templates/cabecalho.html');
      $rodape = file_get_contents('../root/templates/rodape.html');
      echo $cabecalho;
   } else {
      echo "ERROR";
      return false;
   }
?>

<!--

   PAINEL DE CONTROLE
   ATUALIZADO: 20/12/2018

-->
<div id="main">

   <ul id='menu' class='side-nav fixed'>
      <div id="menuID"></div>
   </ul>

   <div class="carousel carousel-slider center" style="height: 100vh;">
		<div class="carousel-fixed-item center">
			<a href="#" data-activates="menu" class="button-collapse top-nav full hide-on-large-only btn waves-effect grey darken-4"><i class="material-icons">menu</i></a>
			<a class="btn waves-effect grey darken-4">DOCUMENTAÇÃO</a>
		</div>
    	<div class="carousel-item indigo darken-4 white-text " style="background-image: url('../img/bg-azul.jpg');" href="#one!">
      
			<div class="centro-div">

				<div class="row">
					<div class="col s12" style="background-color: #5522"><h1>1 Pessoas</h1></div>
					<div class="col s12" style="background-color: #5555"><h1>1 Livros</h1></div>
				</div>

			</div>     

   	</div>

		<div class="carousel-item blue darken-2 white-text" href="#two!">

			<h2>Second Panel</h2>
			<p class="white-text">This is your second panel</p>
		</div>

		<div class="carousel-item blue darken-3 white-text" href="#three!">

			<h2>Third Panel</h2>
			<p class="white-text">This is your third panel</p>
		</div>

		<div class="carousel-item blue darken-4 white-text" href="#four!">

			<h2>Fourth Panel</h2>
			<p class="white-text">This is your fourth panel</p>
		</div>

  	</div>
         
</div>
   
<script>
   $(document).ready(function() { 
      $(".button-collapse").sideNav();
      menu();
      $('.carousel.carousel-slider').carousel({
         fullWidth: true,
         indicators: true
      });
   });
</script>

<?php

   echo $rodape;

      