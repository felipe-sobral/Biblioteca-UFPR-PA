<?php
    include "cfg.php";
    session_start();
    session_destroy();
    header('location: login.html');
    echo "<script> alert('Você desconectou!') </script>";
    exit;
?>
