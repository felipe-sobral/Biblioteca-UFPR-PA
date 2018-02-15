<?php
    include "cfg.php";
    session_start();
    session_destroy();
    echo "Você saiu!";
?>