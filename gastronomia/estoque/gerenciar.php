<?php
require '../includes/auth.php';
require '../includes/db.php';

$query = $pdo->query("SELECT * FROM Ingrediente");
$ingredientes = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Estoque</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Estoque</h2>
    <ul>
        <?php foreach ($ingredientes as $ingrediente): ?>
            <li><?= $ingrediente['nome']; ?> - <?= $ingrediente['quantidade']; ?> <?= $ingrediente['unidade']; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
