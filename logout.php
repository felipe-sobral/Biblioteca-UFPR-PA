<?php
    include "cfg.php";
    session_start();
    session_destroy();
    echo "Você saiu! <a href='index.html'>Clique aqui</a> para voltar a página incial. ";
?>