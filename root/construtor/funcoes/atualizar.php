<?php
   require_once "../../init.php";
   require_once CONSTRUTOR;
   require_once ESTATISTICA_USUARIOS;
   require_once CONSULTA_LOCAL;

   $att;

   $att = new ConsultaLocal(sha1("consulta_local"));  

   $att->atualizar(date("Y-m-d"));