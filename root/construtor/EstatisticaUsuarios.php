<?php
   class EstatisticaUsuarios extends Construtor{

      function __construct(){
         $this->tabela = "e_usuarios";
      }

      /**
       * Adicionar DATA / MANHA / TARDE / NOITE (passados para a função) no banco de dados
       * 
       * @param array $dados
       * 
       * @return bool
       */
      function adicionar($dados){
         $banco = new Query;

         if(isset($dados["data"], $dados["manha"], $dados["tarde"], $dados["noite"])){

            $banco->inserir($this->tabela, $dados);
         
            if($banco->executar()){
               return true;
            }

         }

         return false;
      }

      /**
       * Seleciona dados da tabela correspondente ao ANO e MÊS passados na função
       * 
       * @param array $dados
       * 
       * @return bool
       */
      function historico($dados){

         if(!isset($dados["mes"], $dados["ano"])){
            return false;
         }

         $banco = new Query;

         $vMes = $banco->valor("mes", $dados['mes']);
         $vAno = $banco->valor("ano", $dados['ano']);

         $banco->selecionar($this->tabela, "*", "MONTH(data) = $vMes AND YEAR(data) = $vAno");

         if($banco->executar()){

            $itens = $banco->assoc_array();

            if(!isset($itens[0])){
               return false;
            }

            $this->data_tabela = $itens;
            return true;
         }

         return false;
      }

      /**
       * Altera informações da estatística do usuário da data correspondente
       * 
       * @param array $dados
       * 
       * @return bool
       */
      function alterar($dados){

         if(!isset($dados['data'])){
            return false;
         }
         
         $data = $dados['data'];
         unset($dados['data']);

         $banco = new Query;
         $vData = $banco->valor("data", $data);

         if(isset($dados['deletar'])){
            if($dados['deletar'] === "true"){

               $banco->excluir($this->tabela, "data = $vData");
               
               if($banco->executar()){
                  return true;
               }

               return false;
            }
            
            unset($dados['deletar']);
         }

         $banco->alterar($this->tabela, $dados, "data = $vData");
         
         if($banco->executar()){
            return true;
         }
         
         return false;
      }

      function formulario_alterar($itens){
         $form = new FormularioComJquery('form_EDITAR_CU');

         $form->linha([
                     $form->caixa("EDITAR_CU_manha", "Manhã", "number", "value='".$itens['manha']."' min='0'", 4),
                     $form->caixa("EDITAR_CU_tarde", "Tarde", "number", "value='".$itens['tarde']."' min='0'", 4),
                     $form->caixa("EDITAR_CU_noite", "Noite", "number", "value='".$itens['noite']."' min='0'", 4),
                  ]);
         
         $form->linha([
                     $form->caixa("EDITAR_CU_data", "Data", "text", "disabled value='".$itens['data']."'", 12)
                  ]);
                           
         $form->linha([
                     $form->switch("EDITAR_CU_deletar", "Alterar", "Deletar"),
                     $form->botao_enviar("SUBMETER")
                  ], "centralizar");

         

         $form->print();

         $chaves = [
            "cod" => $form->tabela("e_usuarios"),
            "data" => $form->valor("EDITAR_CU_data"),
            "manha" => $form->valor("EDITAR_CU_manha"),
            "tarde" => $form->valor("EDITAR_CU_tarde"),
            "noite" => $form->valor("EDITAR_CU_noite"),
            "deletar" => "$('#EDITAR_CU_deletar').is(':checked')",
            "stat" => $form->item("ALTERAR")
         ];
         
         $form->criar_chamada($form->item("http://localhost/root/scripts/AA_alterar.php"), $chaves, "console.log(retorno)");
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

      /**
       * Retorna o turno correspondete a hora informada
       * 
       * @param int $horas
       * 
       * @return string
       */
      private function turno($horas){
         switch ($horas) {
            case ($horas >= 7 && $horas < 12):
               return "manha";
               break;
            
            case ($horas >= 12 && $horas < 18):
               return "tarde";
               break;
            
            case ($horas >= 18 && $horas < 23):
               return "noite";
               break;
         }
      }

      /**
       * Retorna a quantidade de usuários que foram registrados no dia informado
       * 
       * ! PRECISA TESTAR
       * 
       * @param string $data
       * 
       * @return string
       */
      function atualizar($data){
         $turno = $this->turno(date('G')-3);

         $query = new Query;

         $vData = $query->valor("data", $data);

         $query->selecionar($this->tabela, $turno, "data = $vData");
         $query->executar();

         $dados = $query->assoc_array();

         if($dados){
            retorna(true, $dados[$turno]);
            exit;
         }
         
         retorna(true, "0");
         exit;
      }
   }