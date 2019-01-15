<?php

   include "../init.php";

   $att = new ConsultaLocal(sha1("consulta_local"));

   $att->atualizar(date("Y-m-d"));