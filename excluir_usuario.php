<?php 
session_start();
require_once 'conexao.php';

// Verifica se o usuario tem permissão de ADM ou Secretária
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}
// Inicializa a variável
$usuario = null;

// busca todos os usuarios cadastrados em ordem alfabética
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se um id for passado por via get, Eclui o usuario
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];
    
    // Exclui o usuario do banco de dados
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if($stmt->execute()) {
        echo "<script>alert('Usuario Excluido Com Sucesso!');window.location.href='excluir_usuario.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir o Usuario.');window.location.href='buscar_usuario.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <link rel="stylesheet" href="Estilo/styles.css">
    <link rel="stylesheet" href="Estilo/style.css">
</head>
<body>
    <h2>Excluir Usuário:</h2>
    <?php if(!empty($usuarios)):?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>

            <?php foreach($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['nome']); ?></td>
                    <td><?= htmlspecialchars($usuario['email']); ?></td>
                    <td><?= htmlspecialchars($usuario['id_perfil']); ?></td>
                    <td>
                        <a href="excluir_usuario.php?id=<?= htmlspecialchars($usuario['id_usuario']); ?>" onclick="return confirm('Tem Certeza que você que deseja excluir esse usuario?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuário encontrado.</p>
    <?php endif; ?>
    <a href="principal.php">Voltar</a>
</body>
</html>