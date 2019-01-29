<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once QUERY;

   /**
    * Seleciona construtor por uma string SHA1
    *
    * Retorna objeto caso SHA1 exista e FALSE caso contrário
    *
    * @param string $tabela
    *
    * @return object|bool
    */
   function seleciona_construtor($tabela){

      switch($tabela){
         case sha1("e_usuarios"):
            $exec = new EstatisticaUsuarios();
            return $exec;
   
         case sha1("consulta_local"):
            $exec = new ConsultaLocal();
            return $exec;
   
         default:
            return false;
      }

   }


   class Construtor{

      protected $tabela;
      protected $data_tabela;
      
      /**
       * Contém todas tabelas do banco de dados
       * 
       * Usado para selecionar a tabela a partir de uma string criptografada
       * 
       * @param string $cod
       * 
       * @return string|bool
       */
      private function lista_tabelas($cod){
         $tabelas = [sha1("consulta_local") => "consulta_local",
                     sha1("e_usuarios")     => "e_usuarios", 
                     sha1("livros")         => "livros",
                     sha1("log")            => "log",
                     sha1("usuarios")       => "usuarios"];
   
         foreach($tabelas as $sha1 => $tabela){
            if($cod == $sha1){
               return $tabela;
            }
         }
   
         return false;
      }

      function __construct($tabela){

         $tb = $this->lista_tabelas($tabela);

         if(!$tb){
            return false;
         }
         
         $this->tabela = $tb;
      }

      // ADICIONAR

      // HISTORICO

      function get_dataTabela(){
         return $this->data_tabela;
      }

      /**
       * Busca no banco de dados informações correspondentes a data [DIA, MES, ANO] informada ao chamar esta função
       * 
       * @param array $dados ["DIA", "MES", "ANO"]
       * 
       * @return array|bool 
       */
      function buscar($dados){
         if(!isset($dados["dia"], $dados["mes"], $dados["ano"])){
            return false;
         }

         $banco = new Query;

         $vDia = $banco->valor("dia", $dados['dia']);
         $vMes = $banco->valor("mes", $dados['mes']);
         $vAno = $banco->valor("ano", $dados['ano']);

         $banco->selecionar($this->tabela, "*", "DAY(data) = $vDia AND MONTH(data) = $vMes AND YEAR(data) = $vAno");
         $banco->executar();

         $itens = $banco->assoc_array();

         if(!isset($itens[0])){
            return false;
         }

         return $itens[0];
      }
   }

   

   