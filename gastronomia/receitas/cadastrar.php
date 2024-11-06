<?php
// Incluindo a conexão PDO
include('../includes/db.php');  // Incluindo a conexão com o banco de dados

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $ingredientes = $_POST['ingredientes'];
    $id_chef_gerente = $_POST['id_chef_gerente'];  // O ID do chef ou gerente que está cadastrando

    try {
        // Inserindo os dados na tabela 'receita'
        $query = "INSERT INTO receita (nome, ingredientes, id_chef_gerente) VALUES (:nome, :ingredientes, :id_chef_gerente)";
        $stmt = $pdo->prepare($query);

        // Bind dos parâmetros para evitar SQL Injection
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ingredientes', $ingredientes);
        $stmt->bindParam(':id_chef_gerente', $id_chef_gerente);

        // Executa a query
        $stmt->execute();

        // Redireciona para a página de listagem ou outra página desejada
        header("Location: listar.php");
        exit;  // Encerra o script após o redirecionamento

    } catch (PDOException $e) {
        echo "Erro ao cadastrar receita: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Receita</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- CDN atualizado para os ícones -->
    <link rel="stylesheet" href="../css/receitas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
    <script src="../js/app.js" defer></script>
    <script src="../js/receitas.js" defer></script>
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
            position: relative; /* Para posicionar a barra abaixo do título */
        }

        header::after {
            content: ""; /* Necessário para criar uma pseudo-elemento */
            display: block; /* Exibe como um bloco */
            width: 100%; /* Largura total */
            height: 4px; /* Espessura da barra */
            background-color: #42392a; /* Cor da barra */
            margin-top: 10px; /* Espaçamento acima da barra */
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad; /* Cor de fundo do formulário */
            padding: 20px; /* Padding interno do formulário */
            border-radius: 5px; /* Bordas arredondadas */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra do formulário */
            width: 100%; /* Largura total */
            max-width: 600px; /* Largura máxima */
        }

        label {
            font-weight: bold; /* Negrito para labels */
            margin-top: 10px; /* Margem superior */
            display: block; /* Faz com que as labels fiquem em blocos */
            color: #42392a; /* Cor do texto das labels */
        }

        input[type="text"] {
            width: calc(100% - 22px); /* Largura total menos o padding */
            padding: 10px; /* Padding interno */
            border: 1px solid #ccc; /* Borda do input */
            border-radius: 5px; /* Bordas arredondadas */
            margin-bottom: 15px; /* Margem inferior */
            font-size: 16px; /* Tamanho da fonte */
        }

        /* Estilo dos botões */
        .btn {
            background-color: #887b66; /* Cor dos botões */
            color: #42392a; /* Cor do texto dos botões */
            padding: 15px 25px; /* Tamanho do botão */
            font-size: 18px; /* Tamanho da fonte */
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
    <?php include '../includes/header.php'; ?>
    <h2>Cadastrar Receita</h2>
    <form method="POST" action="cadastrar.php">
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Ingredientes:</label>
        <input type="text" name="ingredientes" id="ingredientes" required autocomplete="off">
        <div class="suggestions" id="suggestions"></div>

        <!-- Campo oculto para o id_chef_gerente -->
        <input type="hidden" name="id_chef_gerente" value="<?php echo $_SESSION['id_usuario']; ?>">

        <div class="botao-container">
            <button type="submit" class="btn">
                <i class="fa-light fa-check"></i>
            </button>

            <a href="listar.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a> <!-- Botão de voltar com ícone -->
        </div>
    </form>
</body>
</html>
