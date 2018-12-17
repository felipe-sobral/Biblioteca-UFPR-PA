<?php
   /*if(!isset($_SESSION['usuario'])){
      return;
   }*/

   class Menu{
      private $comeco;
      private $itens;

      public function __construct(){
         $this->comeco = "
            <li><div class='user-view'>
               <div class='background'>
                  <img src='../img/bg.jpg'>
               </div>
               <center><a href='../home_restrita.html'><img src='../img/branco_UFPR.png' width='188vh'></a>
               <h5 id='nomeID' class='card-title text-light'>teste</h5>
            </div></li>";

         $this->itens = "";
         
      }

      //<li><a class='collapsible-header waves-effect' style='text-decoration:none' href='../contador_usuario/painel.html'><i class='material-icons'>star_rate</i>Contador de usuários</a></li>
      public function item($icon, $texto, $endereco){
         $str = "<li><a class='collapsible-header waves-effect' style='text-decoration:none' href='{$endereco}'><i class='material-icons'>{$icon}</i>{$texto}</a></li>";
         return $str;
      }

      public function dropdown($icon, $texto, $itens){
         $str = " <li>
                     <ul class='collapsible collapsible-accordion'>
                        <li>
                           <a class='collapsible-header waves-effect' style='text-decoration:none; outline: 0;'><i class='material-icons'>{$icon}</i>{$texto}</a>
                           <div class='collapsible-body'>
                              <ul>";

         foreach($itens as $item){
            $str .= $this->item($item[0], $item[1], $item[2]);
         }

         $str .= "
                                 <li><div class='divider'></div></li>
                              </ul>
                           </div>
                        </li>
                     </ul>
                  </li>";

         return $str;
      }

      public function addSpacer(){
         $this->itens .= "<hr width='200vh'/>";
      }

      public function addItem($str){
         $this->itens .= $str;
      }

      public function menuJS(){
         echo $this->comeco.$this->itens;
      }

   }

   $menu = new Menu;

   $dropUsuarios = [["group_add", "Contador", "#"], ["add", "Adicionar", "#"], ["history", "Histórico", "#"], ["edit", "Alterar", "#"]];
   $dropConsultaLivros = [["note_add", "Registrar códigos", "#"], ["add", "Adicionar", "#"], ["history", "Histórico", "#"], ["edit", "Alterar", "#"], ["cloud_download", "Baixar", "#"]];

   $menu->addItem($menu->item("star_rate", "Contador de usuários", "#"));
   $menu->addItem($menu->item("star_rate", "Registrador consulta local", "#"));
   $menu->addSpacer();
   $menu->addItem($menu->dropdown("people", "Estatística de Usuários", $dropUsuarios));
   $menu->addItem($menu->dropdown("assignment", "Estatística Consulta Local", $dropConsultaLivros));
   $menu->addItem($menu->item("exit_to_app", "Sair", "../../root/secoes/usuarios/deslogar.php"));


   $menu->menuJS();