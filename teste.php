<?php
   require_once "root/init.php";
   require_once QUERY;

   $teste = new Query;

   $teste->alterar("e_usuarios", ["manha" => "@manha + 1@"], "data = '2019-01-20'");
   $teste->testar();
   // ÁREA DE TESTES