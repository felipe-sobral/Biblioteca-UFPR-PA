<?php
   class Construtor{

      protected $tabela;
      protected $data_tabela;

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
   
         retornoErro(2);
         exit;
      }

      private function verificar_tabela($tabela){
         if($tabela != null){
            
            $this->tabela = $this->lista_tabelas($tabela);

         } else {
            retornoErro(1);
            exit;
         }

      }

      function __construct($tabela){

         $this->verificar_tabela($tabela);

      }

      function adicionar($dados, $permissao){

         if(inserir_padrao($this->tabela, $dados)){

            retornoPadrao(true, "INSERIDO COM SUCESSO!");
            exit;

         }

         retornaErro(3);
         exit;

      }

      function historico($dados, $permissao){

         if(!isset($dados['mes'], $dados['ano'])){
            retornaErro(4);
            exit;
         }

         $sql = new Query;

         $vMes = $sql->valor("mes", $dados['mes']);
         $vAno = $sql->valor("ano", $dados['ano']);

         $sql->selecionar($this->tabela, "*", "MONTH(data) = $vMes AND YEAR(data) = $vAno");

         if($sql->executar()){

            $itens = $sql->assoc_array();

            if($itens == null){
               retornaErro(5);
               exit;
            }

            $this->data_tabela = $itens;
            
         }
      }

      function get_dataTabela(){
         return $this->data_tabela;
      }

      function buscar($dados, $permissao){
         if(!isset($dados["dia"], $dados["mes"], $dados["ano"])){
            retornoErro(4);
            exit;
         }

         $sql = new Query;

         $vDia = $sql->valor("dia", $dados['dia']);
         $vMes = $sql->valor("mes", $dados['mes']);
         $vAno = $sql->valor("ano", $dados['ano']);

         $sql->selecionar($this->tabela, "*", "DAY(data) = $vDia AND MONTH(data) = $vMes AND YEAR(data) = $vAno");
         $sql->executar();

         $itens = $sql->assoc_array();

         if($itens === null){
            retornoErro(5);
            exit;
         }

         return $itens;
      }

      function alterar($dados, $permissao){

         if(!isset($dados['data'])){
            retornoErro(4);
            exit;
         }
         
         $data = $dados['data'];
         unset($dados['data']);

         $query = new Query;

         if(isset($dados['deletar'])){
            if($dados['deletar'] == "true"){
               if($query->deletar($this->tabela, "data", $data)->construir()){
                  echo "#true";
                  exit;
               }
            } else {
               unset($dados['deletar']);
            }
         }

         
         if($query->alterar($this->tabela, $dados)
                  ->quando()
                  ->parametro("data", '=', $data)
                  ->construir()){
            
            echo "#true";
            exit;
         }
         
      }
   }

   

   