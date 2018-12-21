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

   PAINEL DE CONTROLE - Contador Usuários
   ATUALIZADO: 21/12/2018

-->
<div id="main">

   <ul id='menu' class='side-nav fixed'>
      <div id="menuID"></div>
   </ul>

   <div class="carousel carousel-slider center" style="height: 100vh;">
      
    	<div class="carousel-item" href="#one!">
      
         <div class="container" style="padding-top: 10%;">
            <i class="material-icons" style="font-size: 150px">group_add</i>
            <h1>Contador</h1>
            <div class="card-panel centralizar z-depth-5" style="background-color: #FFF; width: 250px">
               <h1 id="contador" style="color: #161616">00</h1>
               <hr style="border-top: 2px; border-color: #f3f3f3;">
               <a class="waves-effect waves-light btn-large green" onClick="atualizar_contador(1)"><i class="material-icons">add</i></a>
               <a class="waves-effect waves-light btn-large red" onClick="atualizar_contador(-1)"><i class="material-icons">remove</i></a>
            </div>
            

         </div>

   	</div>

		<div class="carousel-item white-text" href="#two!">

			<h2>Second Panel</h2>
         <p class="white-text">This is your second panel</p>
         
		</div>

		<div class="carousel-item white-text" href="#three!">

			<h2>Third Panel</h2>
         <p class="white-text">This is your third panel</p>
         
		</div>

		<div class="carousel-item white-text" href="#four!">

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
      atualizar_contador(0);
   });
</script>

<?php

   echo $rodape;