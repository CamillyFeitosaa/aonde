<?php
require '../includes/db.php';
session_start();

// Verifica se o ID da receita foi passado
if (!isset($_GET['id'])) {
    header("Location: listar.php"); // Redireciona para a lista se o ID não for encontrado
    exit();
}

$id_receita = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $unidade = $_POST['unidade'];

    // Insere o novo ingrediente no banco de dados
    // Use o nome correto da tabela, que é 'ingrediente' (singular)
    $insertStmt = $pdo->prepare("INSERT INTO ingrediente (nome, quantidade, unidade, receita_id) VALUES (:nome, :quantidade, :unidade, :receita_id)");
    $insertStmt->bindParam(':nome', $nome);
    $insertStmt->bindParam(':quantidade', $quantidade);
    $insertStmt->bindParam(':unidade', $unidade);
    $insertStmt->bindParam(':receita_id', $id_receita);
    
    // Executa a inserção
    if ($insertStmt->execute()) {
        header("Location: listar.php"); // Redireciona após a adição
        exit();
    } else {
        echo "Erro ao adicionar ingrediente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Ingrediente</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Adicionar Ingrediente</h2>
    <form method="POST" action="">
        <label for="nome">Nome do Ingrediente:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required>

        <label for="unidade">Unidade:</label>
        <input type="text" name="unidade" id="unidade" required>

        <button type="submit">Adicionar</button>
        <a href="listar.php">Cancelar</a>
    </form>
</body>
</html>
