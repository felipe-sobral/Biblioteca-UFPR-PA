<?php
   require_once QUERY;

   class EstatisticaUsuarios extends Construtor{

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
         $form = new FormularioComJquery('form_EU_editar');

         $form->linha([
                     $form->caixa("EU_ed_manha", "Manhã", "number", "value='".$itens['manha']."' min='0'", 4),
                     $form->caixa("EU_ed_tarde", "Tarde", "number", "value='".$itens['tarde']."' min='0'", 4),
                     $form->caixa("EU_ed_noite", "Noite", "number", "value='".$itens['noite']."' min='0'", 4),
                  ]);
         
         $form->linha([
                     $form->caixa("EU_ed_data", "Data", "text", "disabled value='".$itens['data']."'", 12)
                  ]);
                           
         $form->linha([
                     $form->switch("EU_ed_deletar", "Alterar", "Deletar"),
                     $form->botao_enviar("SUBMETER")
                  ], "centralizar");

         

         $form->print();

         $chaves = [
            "cod" => $form->tabela("e_usuarios"),
            "data" => $form->valor("EU_ed_data"),
            "manha" => $form->valor("EU_ed_manha"),
            "tarde" => $form->valor("EU_ed_tarde"),
            "noite" => $form->valor("EU_ed_noite"),
            "deletar" => "$('#EU_ed_deletar').is(':checked')",
            "stat" => $form->item("ALTERAR")
         ];
         $form->criar_chamada($form->item("../root/funcoes/alterar.php"), $chaves, "console.log(retorno)");
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
         
         retorna(false, "A OPERAÇÃO FALHOU");
         exit;
      }
   }