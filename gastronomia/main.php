<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão
require 'includes/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
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

        /* Estilos para o nav */
        nav {
            margin-top: 20px; /* Espaçamento acima do nav */
            position: relative; /* Para posicionar o botão de sair */
            text-align: center; /* Centraliza os links de navegação */
            flex-grow: 1; /* Permite que a nav cresça para ocupar espaço */
        }

        .btn-sair {
            position: absolute; /* Posiciona o botão no canto superior direito */
            top: -117px; /* Distância do topo ajustada para -55px (anteriormente -75px) */
            right: 10px; /* Distância da direita */
            padding: 8px 15px; /* Aumentando o tamanho do botão de sair */
            font-size: 16px; /* Aumentando o tamanho da fonte */
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
        <h1>Dashboard do Sistema</h1>
    </header>

    <!-- Exibe a função do usuário -->
    <h2>Bem-vindo(a) ao sistema, <?php echo isset($_SESSION['chef_gerente']) ? htmlspecialchars($_SESSION['chef_gerente']) : 'Usuário'; ?>!</h2>
    
    <nav>
        <a href="receitas/listar.php" class="btn">
            <i class="fas fa-lightbulb"></i> Gerenciar Receitas <!-- Ícone de lâmpada adicionado -->
        </a>
        <a href="estoque/listar.php" class="btn">
            <i class="fas fa-user"></i> Gerenciar Estoque <!-- Ícone de perfil adicionado -->
        </a>
        <a href="logout.php" class="btn btn-sair">Sair</a> <!-- Adicionada a classe btn-sair -->
    </nav>
    
    <footer>
        <p>&copy; 2024 Sistema de Gerenciamento</p>
    </footer>
</body>
</html>
