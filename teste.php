<?php

   require "root/init.php";

   $teste = new Query();
         /*
         $txt = $teste->select("usuarios", "nome")
                      ->parametro("usuario", "=", "Felipe")
                      ->construir();
                      */
         
   $teste->select(["usuarios", "livros"], ["nome"])
         ->parametro("usuario", "=", "Felipe")
         ->and()
         ->parametro("teste", "=", "Teste")
         ->and()
         ->parametro("outro", "=", "Teste")
         ->construir();