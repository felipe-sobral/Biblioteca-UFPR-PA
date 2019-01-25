<?php
   require_once "root/init.php";
   require_once QUERY;

   echo session_id();
   echo "<br><br>";
   echo $_COOKIE["PHPSESSID"];

   // ÁREA DE TESTES