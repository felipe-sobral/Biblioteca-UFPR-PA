<?php
   session_start();

   require "../init.php";

   $dados = $_POST;

   $exec = new Construtor( isset($dados["cod"]) ? $dados["cod"]:null );

   unset($dados["cod"]);
   
   $exec->adicionar($dados, 2);