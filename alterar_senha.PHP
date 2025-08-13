<?php
session_start();
require_once 'conexao.php';

// Garante que o usuario esteja logado
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso Negado');window.location.href='login.php';</script>";  
    exit();
}






?>