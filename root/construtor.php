<?php

   /*

      #1# -> TABELA NÃO SELECIONADA
      #2# -> TABELA INVÁLIDA
      #3# -> ERRO INSERIR
      #4# -> VALORES INCOMPATÍVEIS
      #5# -> ERRO AO SELECIONAR OU NÃO EXISTE

   */

   function lista_tabelas($cod){
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


      echo "#2#";
      exit;
   }


   class Construtor{

      private $tabela;
      private $data_tabela;

      private function verificar_tabela($tabela){
         if($tabela != null){
            
            $this->tabela = lista_tabelas($tabela);

         } else {
            echo "#1#";
            exit;
         }

      }

      function __construct($tabela){

         $this->verificar_tabela($tabela);

      }

      function adicionar($dados, $permissao){

         if(!inserir_padrao($this->tabela, $dados)){
            echo "#3#";
            exit;
         } else {
            echo "#true";
            exit;
         }

      }

      function historico($condicoes, $permissao){
         $sql = new Query;

         if(!isset($condicoes, $condicoes['mes'], $condicoes['ano'])){
            echo "#4#";
            exit;
         }

         if($sql->select([$this->tabela], ['*'])->parametro('MONTH(data)', '=', $condicoes['mes'])->and()->parametro('YEAR(data)', '=', $condicoes['ano'])->construir()){

            $itens = $sql->array_assoc_multi();

            if($itens == null){
               echo "#5#";
               return false;
            }

            $this->data_tabela = $itens;
            
         }
      }

      function get_dataTabela(){
         return $this->data_tabela;
      }

      function buscar($dados, $permissao){

         if(!isset($dados['dia'], $dados['mes'], $dados['ano'])){
            echo "#false";
            exit;
         }
   
         $query = new Query;
         if($query->select([$this->tabela], ['*'])
                ->parametro('DAY(data)', '=', $dados['dia'])
                ->and()
                ->parametro('MONTH(data)', '=', $dados['mes'])
                ->and()
                ->parametro('YEAR(data)', '=', $dados['ano'])
                ->construir()){
            
            $dia = $query->array_assoc();
   
            if($dia == null){
               echo "#4#";
               exit;
            }   
         }

         return $dia;
      }
   }

   class EstatisticaUsuarios extends Construtor{

      function contar(){

      }

      function tabela($itens){
         $tabela = new Tabela(["Data", "Manhã", "Tarde", "Noite", "Total"]);
         $totais = [0, 0, 0];
   
         foreach($itens as $item){
            $data = new DateTime($item['data']);
            $total = $item['manha']+$item['tarde']+$item['noite'];
   
            $totais[0] += $item['manha'];
            $totais[1] += $item['tarde'];
            $totais[2] += $item['noite'];
   
            $tabela->addItem([$data->format('d/m/Y'), $item['manha'], $item['tarde'], $item['noite'], $total]);
         }
   
         $tabela->addItem(["<strong>TOTAL</strong>", "$totais[0]", "$totais[1]", "$totais[2]", $totais[0]+$totais[1]+$totais[2]]);
   
   
         $tabela->print();
      }

      function formulario($itens){
         $formulario = new Formulario('form_EU_editar');

         $formulario->linha([
                              $formulario->caixa("EU_ed_manha", "Manhã", "number", null, $itens['manha'], 4),
                              $formulario->caixa("EU_ed_tarde", "Tarde", "number", null, $itens['tarde'], 4),
                              $formulario->caixa("EU_ed_noite", "Noite", "number", null, $itens['noite'], 4),
                            ]);
         
         $formulario->linha([
                              $formulario->caixa("EU_ed_data", "Data", "text", null, $itens['data'], 12)
                            ]);
                            
         $formulario->linha([
                              $formulario->switch("EU_ed_deletar", "Alterar", "Deletar"),
                              $formulario->botao_enviar("SUBMETER")
                            ]);

         $formulario->print();
      }
   }