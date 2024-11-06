<?php
require '../includes/auth.php';
require '../includes/db.php';

// Consulta para listar receitas
try {
    $stmt = $pdo->query("SELECT * FROM receita");
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as an associative array
} catch (PDOException $e) {
    echo "Erro ao consultar receitas: " . $e->getMessage();
    $receitas = []; // Defina como um array vazio para evitar erros no foreach
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/receitas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
    <script src="../js/app.js" defer></script>
    <script src="../js/receitas.js" defer></script>
    <title>Listar Receitas</title>
    <style>
        /* Estilo global */
        body {
            background-color: #B09779; /* Cor de fundo */
            color: #fae5ad; /* Cor do texto */
            font-family: Arial, sans-serif; /* Fonte padrão */
            margin: 0; /* Remove margem padrão */
            padding: 20px; /* Adiciona padding ao corpo */
            display: flex; /* Flexbox para alinhar os elementos */
            flex-direction: column; /* Direção vertical */
            align-items: center; /* Centraliza os itens */
        }

        /* Estilo do cabeçalho */
        header {
            background-color: #fae5ad; /* Cor da barra superior */
            color: #42392a; /* Cor do texto do cabeçalho */
            padding: 10px 20px; /* Padding para o cabeçalho */
            text-align: center; /* Centraliza o texto do cabeçalho */
            border-radius: 5px; /* Bordas arredondadas */
            margin-bottom: 20px; /* Espaçamento inferior */
        }

        /* Estilo da lista de receitas */
        .receitas-container {
            background-color: #fae5ad; /* Cor de fundo do container */
            padding: 20px; /* Padding interno do container */
            border-radius: 5px; /* Bordas arredondadas */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra do container */
            width: 100%; /* Largura total */
            max-width: 600px; /* Largura máxima */
        }

        /* Estilos para os botões */
        .btn {
            background-color: #887b66; /* Cor da barra para botões */
            color: #42392a; /* Cor do texto dos botões */
            padding: 15px 25px; /* Tamanho do botão */
            font-size: 18px; /* Aumentando o tamanho da fonte */
            border: none; /* Sem borda */
            border-radius: 5px; /* Bordas arredondadas */
            text-decoration: none; /* Sem sublinhado */
            display: inline-block; /* Para manter na mesma linha */
            margin: 10px; /* Margem para separação */
            text-align: center; /* Centraliza o texto no botão */
            transition: background-color 0.3s; /* Transição suave */
        }

        .btn:hover {
            background-color: #42392a; /* Cor do botão ao passar o mouse */
            color: #fae5ad; /* Mantém a cor do texto */
        }

        /* Estilos para a lista de receitas */
        .receitas-list {
            list-style-type: none; /* Remove marcadores da lista */
            padding: 0; /* Remove padding padrão */
            margin: 20px 0; /* Margem vertical */
        }

        .receitas-list li {
            background-color: #e6e1c3; /* Cor de fundo dos itens da lista */
            padding: 10px; /* Padding interno dos itens */
            border-radius: 5px; /* Bordas arredondadas dos itens */
            margin-bottom: 10px; /* Margem inferior entre itens */
            display: flex; /* Usar flexbox para alinhar itens */
            justify-content: space-between; /* Espaço entre os itens */
            align-items: center; /* Alinhar ao centro verticalmente */
        }

        .receitas-list li strong {
            color: #42392a; /* Cor do texto das receitas */
        }

        /* Estilo do rodapé */
        footer {
            background-color: #fae5ad; /* Cor da barra inferior */
            color: #42392a; /* Cor do texto do rodapé */
            text-align: center; /* Centraliza o texto do rodapé */
            padding: 10px 0; /* Padding para o rodapé */
            margin-top: 10px; /* Margem superior para separação */
            border-radius: 5px; /* Bordas arredondadas */
        }
    </style>
</head>
<body>
    <header>
        <h1>Lista de Receitas</h1>
    </header>

    <div class="receitas-container">
        <!-- Link para o cadastro de receita -->
        <p>
            <a href="cadastrar.php" class="btn">
                <i class="fas fa-plus"></i> Cadastrar nova receita
            </a>
        </p>

        <ul class="receitas-list">
            <?php if (!empty($receitas)): ?>
                <?php foreach ($receitas as $receita): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($receita['nome']); ?></strong>
                        <div>
                            <a href="editar_ingredientes.php?id=<?php echo $receita['id']; ?>" class="btn">
                                <i class="fas fa-edit"></i> Editar Ingredientes
                            </a>
                            <a href="#" class="excluir-receita btn" data-id="<?php echo $receita['id']; ?>">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Nenhuma receita encontrada.</li>
            <?php endif; ?>
        </ul>

        <!-- Link para voltar à tela de índice -->
        <p>
            <a href="../main.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a>
        </p>
    </div>

    <footer>
        <p>&copy; 2024 Gastronomia</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const excluirLinks = document.querySelectorAll('.excluir-receita');

            excluirLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Evita que o link recarregue a página
                    const receitaId = this.dataset.id;

                    if (confirm('Tem certeza que deseja excluir esta receita?')) {
                        fetch(`excluir.php?id=${receitaId}`, {
                            method: 'GET',
                        })
                        .then(response => {
                            if (response.ok) {
                                // Remove a receita da lista
                                this.closest('li').remove();
                                alert('Receita excluída com sucesso!');
                            } else {
                                alert('Erro ao excluir receita.');
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert('Erro ao excluir receita.');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
