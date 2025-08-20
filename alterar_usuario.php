<?php
session_start();
require_once 'conexao.php';
// Verifica se o usuario tem permissão de ADM
if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}
// Inicializa as Variaveis
$usuario = null;
// Se o Formulario for enviado, busca o usuario pelo id ou pelo nome
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (!empty($_POST['busca_usuario'])) {
    $busca = trim($_POST['busca_usuario']);

        // Verifica se a busca é um número(id) ou um Nome
        if (is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
        }
        $stmt->execute();
        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Se o Usuario não for encontrado, Exibe um Alerta
        if (!$usuario) {
            echo "<script>alert('Usuario não encontrado!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuario</title>
    <link rel="stylesheet" href="styles.css">
<!-- Sertifique-se de que o javascript esta sendo carregado corretamente -->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Usuarios:</h2>
    <!-- Formulário para Buscar usuarios --> 
     <form action="Alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou Nome do Usuario:</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">

        <div id="sugestoes">


        </div>
        <button type="submit">Pesquisar</button>
     </form>
</body>
</html>