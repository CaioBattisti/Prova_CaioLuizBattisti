<?php
require_once 'conexao.php';

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    echo json_encode(['exists' => $count > 0]);
}
?>