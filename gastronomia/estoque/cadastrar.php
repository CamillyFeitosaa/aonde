<?php
require '../includes/auth.php';  // Inclui a verificação de autenticação
require '../includes/db.php';     // Inclui a conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $unidade = $_POST['unidade'];

    // Prepara a consulta para inserir um novo ingrediente
    $query = $pdo->prepare("INSERT INTO ingrediente (nome, quantidade, unidade) VALUES (:nome, :quantidade, :unidade)");
    $query->bindParam(':nome', $nome);
    $query->bindParam(':quantidade', $quantidade);
    $query->bindParam(':unidade', $unidade);
    $query->execute();  // Executa a consulta

    // Redireciona para a página de listagem de ingredientes após o cadastro
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Ingrediente</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Estilo para a página -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/antd/dist/antd.min.css"> <!-- Ant Design CSS -->
    <script src="https://cdn.jsdelivr.net/npm/react/umd/react.production.min.js"></script> <!-- React -->
    <script src="https://cdn.jsdelivr.net/npm/react-dom/umd/react-dom.production.min.js"></script> <!-- React DOM -->
    <script src="https://cdn.jsdelivr.net/npm/antd/dist/antd.min.js"></script> <!-- Ant Design JS -->
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
            min-height: 100vh; /* Altura mínima da tela */
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

        /* Estilo dos títulos */
        h2 {
            color: #42392a; /* Cor do texto dos títulos */
            text-align: center; /* Centraliza o título */
            margin-bottom: 20px; /* Margem inferior para espaçamento */
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

        /* Estilo para o contêiner do formulário */
        form {
            text-align: center; /* Centraliza o texto no formulário */
            margin-bottom: 20px; /* Margem inferior para espaçamento */
        }

        label {
            display: block; /* Exibe o label como bloco */
            margin: 10px 0; /* Margem acima e abaixo do label */
            font-weight: bold; /* Negrito */
            color: #42392a; /* Cor do texto */
        }

        input[type="text"], input[type="number"], select {
            width: 80%; /* Largura dos campos de entrada */
            padding: 10px; /* Espaçamento interno */
            margin: 5px 0 15px; /* Margem ao redor dos campos */
            border: 1px solid #ccc; /* Borda padrão */
            border-radius: 5px; /* Bordas arredondadas */
            font-size: 16px; /* Tamanho da fonte */
            color: #42392a; /* Cor do texto */
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #887b66; /* Cor da borda ao focar */
            outline: none; /* Remove o contorno padrão */
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
    <?php include '../includes/header.php'; ?>  <!-- Inclui o cabeçalho -->
    
    <h2>Cadastrar Novo Ingrediente</h2>
    
    <form method="POST" action="cadastrar.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" step="0.01" id="quantidade" name="quantidade" required>

        <label for="unidade">Unidade:</label>
        <select id="unidade" name="unidade" required>
            <option value="" disabled selected>Selecione uma unidade</option>
            <option value="kg">Kilograma (kg)</option>
            <option value="g">Grama (g)</option>
            <option value="l">Litro (l)</option>
            <option value="ml">Mililitro (ml)</option>
            <option value="unidade">Unidade (unidade)</option>
        </select>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="btn">
                <i class="fas fa-check"></i> Salvar Ingrediente
            </button>
            <a href="listar.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a> <!-- Botão de voltar -->
        </div>
    </form>

    <?php include '../includes/footer.php'; ?>  <!-- Inclui o rodapé -->
</body>
</html>
