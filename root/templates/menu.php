<?php
   session_start();

   if(!isset($_SESSION, $_SESSION['usuario'], $_SESSION['email'])){
      return;
   }

   class Menu{
      private $comeco;
      private $itens;

      public function __construct(){
         $this->comeco = "
               <li><div class='user-view' style='line-height: 25px !important;'>
                  <div class='background'>
                     <img src='../img/bg.jpg'>
                  </div>
                  <a href='http://localhost/paginas/painel.php' style='margin-left: 10%;'><img src='../img/branco_UFPR.png' width='188vh'></a>
                  <a id='menu_nome'><span class='white-text name'>".$_SESSION['nome']."</span></a>
                  <a id='menu_email'><span class='white-text email'>".$_SESSION['email']."</span></a>
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
         $this->itens .= "<hr style='width: 12vh; border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);'>";
      }

      public function addItem($str){
         $this->itens .= $str;
      }

      public function menuJS(){
         echo $this->comeco.$this->itens;
      }

      public function menu(){
         return ($this->comeco.$this->itens);
      }

   }

   $menu = new Menu;

   $dropUsuarios = [["group_add", "Contador", "http://localhost/paginas/contador_usuarios.php"], ["add", "Adicionar", "http://localhost/paginas/contador_usuarios.php#add"], ["history", "Histórico", "http://localhost/paginas/contador_usuarios.php#h"], ["edit", "Alterar", "http://localhost/paginas/contador_usuarios.php#alt"]];
   $dropConsultaLivros = [["note_add", "Registrar códigos", "http://localhost/paginas/consulta_local.php"], ["add", "Adicionar", "#"], ["history", "Histórico", "#"], ["edit", "Alterar", "#"], ["cloud_download", "Baixar", "#"]];

   $menu->addItem($menu->item("star_rate", "Contador de usuários", "contador_usuarios.php"));
   $menu->addItem($menu->item("star_rate", "Registrador consulta local", "consulta_local.php"));
   $menu->addSpacer();
   $menu->addItem($menu->dropdown("people", "Estatística de Usuários", $dropUsuarios));
   $menu->addItem($menu->dropdown("assignment", "Estatística Consulta Local", $dropConsultaLivros));
   $menu->addItem($menu->item("exit_to_app", "Sair", "../../root/secoes/usuarios/deslogar.php"));


   $menu->menuJS();