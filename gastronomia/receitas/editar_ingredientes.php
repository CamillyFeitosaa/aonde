<?php
require '../includes/auth.php';
require '../includes/db.php';

// Verifica se o ID da receita foi passado
if (!isset($_GET['id'])) {
    header("Location: listar.php"); // Redireciona para a lista se o ID não for encontrado
    exit();
}

$id_receita = $_GET['id'];

// Consulta para obter os dados da receita
try {
    $stmt = $pdo->prepare("SELECT * FROM Receita WHERE id = :id");
    $stmt->bindParam(':id', $id_receita);
    $stmt->execute();
    $receita = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Obtém os ingredientes da coluna 'ingredientes'
    $ingredientes = !empty($receita['ingredientes']) ? explode(',', $receita['ingredientes']) : [];
} catch (PDOException $e) {
    echo "Erro ao consultar receita: " . $e->getMessage();
    exit();
}

// Processar a adição de um novo ingrediente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_ingrediente = $_POST['novo_ingrediente'];

    // Adiciona o novo ingrediente na lista
    $ingredientes[] = $novo_ingrediente;

    // Atualiza a receita com a nova lista de ingredientes
    $ingredientes_str = implode(',', $ingredientes);
    
    try {
        $updateStmt = $pdo->prepare("UPDATE Receita SET ingredientes = :ingredientes WHERE id = :id");
        $updateStmt->bindParam(':ingredientes', $ingredientes_str);
        $updateStmt->bindParam(':id', $id_receita);
        $updateStmt->execute();

        header("Location: editar_ingredientes.php?id=$id_receita"); // Redireciona após a adição
        exit();
    } catch (PDOException $e) {
        echo "Erro ao adicionar ingrediente: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Ingredientes da Receita</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Estilo global */
        body {
            background-color: #B09779;
            color: #fae5ad;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Estilo do cabeçalho */
        header {
            background-color: #fae5ad;
            color: #42392a;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
        }

        header::after {
            content: "";
            display: block;
            width: 100%;
            height: 4px;
            background-color: #42392a;
            margin-top: 10px;
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #42392a;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        /* Estilo dos botões */
        .btn, a.btn {
            background-color: #887b66;
            color: #42392a;
            padding: 15px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 0;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn:hover, a.btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        /* Estilo do rodapé */
        footer {
            background-color: #fae5ad;
            color: #42392a;
            text-align: center;
            padding: 10px 0;
            margin-top: 10px;
            border-radius: 5px;
        }

        h3 {
            margin-top: 20px;
            color: #42392a;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #42392a;
            color: #fae5ad;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Editar Ingredientes da Receita: <?php echo htmlspecialchars($receita['nome']); ?></h2>

    <form method="POST" action="">
        <label for="novo_ingrediente">Novo Ingrediente:</label>
        <input type="text" name="novo_ingrediente" id="novo_ingrediente" required>

        <button type="submit" class="btn">Adicionar Ingrediente</button>
        <a href="listar.php" class="btn">Cancelar</a>
    </form>

    <h3>Ingredientes da Receita</h3>
    <ul>
        <?php if (!empty($ingredientes)): ?>
            <?php foreach ($ingredientes as $ingrediente): ?>
                <li><?php echo htmlspecialchars($ingrediente); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhum ingrediente encontrado.</li>
        <?php endif; ?>
    </ul>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
