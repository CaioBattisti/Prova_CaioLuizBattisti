<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário tem permissão de ADM ou Almoxarife
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

// Só processa se veio via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitização básica
    $id_produto = isset($_POST['id_produto']) ? (int) $_POST['id_produto'] : 0;
    $nome_prod  = trim($_POST['nome_prod']);
    $descricao  = trim($_POST['descricao']);
    $qtde       = isset($_POST['qtde']) ? (int) $_POST['qtde'] : 0;
    $valor_unit = isset($_POST['valor_unit']) ? (float) $_POST['valor_unit'] : 0;

    // Atualiza no banco
    $sql = "UPDATE produto 
               SET nome_prod = :nome_prod, 
                   descricao = :descricao, 
                   qtde = :qtde, 
                   valor_unit = :valor_unit 
             WHERE id_produto = :id_produto";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_prod', $nome_prod);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':qtde', $qtde, PDO::PARAM_INT);
    $stmt->bindParam(':valor_unit', $valor_unit);
    $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Produto atualizado com sucesso!');window.location.href='buscar_produto.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar produto.');window.location.href='alterar_produto.php';</script>";
    }
} else {
    // Se acessarem direto sem POST
    header("Location: alterar_produto.php");
    exit();
}
?>