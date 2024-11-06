<?php 
require '../includes/auth.php';
require '../includes/db.php';

// Consulta os ingredientes no banco de dados
$query = $pdo->query("SELECT * FROM Ingrediente");
$ingredientes = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Ingredientes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.css"> <!-- Link do Ant Design -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.js"></script> <!-- Link do Ant Design JS -->
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
            background-color: #887b66; 
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

        /* Estilo para o contêiner da lista de ingredientes */
        #lista-ingredientes {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Espaçamento entre os cartões */
            margin-top: 20px;
            justify-content: center; /* Centraliza os cartões horizontalmente */
        }

        /* Estilo para cada cartão de ingrediente */
        .ingrediente-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: calc(30% - 15px); /* Três cartões por linha, considerando o gap */
            text-align: center;
            transition: transform 0.2s;
            background-color: #fae5ad; /* Fundo dos cartões */
        }

        .ingrediente-card:hover {
            transform: translateY(-5px); /* Efeito de hover para levantar o cartão */
        }

        h3 {
            margin: 10px 0; /* Margem para o título do ingrediente */
            color: #42392a; /* Cor do texto do título */
        }

        /* Estilo para a quantidade do ingrediente */
        .ingrediente-card p {
            font-size: 18px; /* Tamanho da fonte */
            color: #6a4f31; /* Nova cor para a quantidade */
            font-weight: bold; /* Deixa o texto mais forte */
        }

        /* Estilo para o botão "Excluir" */
        .btn-outline-danger {
            padding: 8px 16px;
            font-size: 14px;
            color: #dc3545;
            background-color: transparent;
            border: 1px solid #dc3545;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px; /* Margem superior para o botão Excluir */
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <h2>Ingredientes no Estoque</h2>
    <div style="text-align: center; margin-bottom: 15px;">
        <a href="cadastrar.php" class="btn">
            <i class="fas fa-plus"></i> Cadastrar Novo Ingrediente
        </a>
    </div>
    
    <div id="lista-ingredientes">
        <?php foreach ($ingredientes as $ingrediente): ?>
            <div class="ingrediente-card" id="ingrediente-<?= $ingrediente['id']; ?>">
                <h3><?= htmlspecialchars($ingrediente['nome']); ?></h3>
                <p>Quantidade: <?= htmlspecialchars($ingrediente['quantidade']); ?> <?= htmlspecialchars($ingrediente['unidade']); ?></p>
                <button type="button" class="btn btn-outline-danger" data-id="<?= $ingrediente['id']; ?>">
                    <span class="anticon anticon-delete"><i class="fas fa-trash"></i> Excluir</span>
                </button>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="../main.php" class="btn">
            <i class="fas fa-arrow-left"></i> Voltar
        </a> <!-- Botão de voltar -->
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-outline-danger').on('click', function() {
                const id = $(this).data('id');

                if (confirm('Tem certeza que deseja excluir este ingrediente?')) {
                    $.ajax({
                        url: 'excluir.php',
                        type: 'GET',
                        data: { id: id },
                        success: function(response) {
                            let data;
                            try {
                                data = typeof response === 'object' ? response : JSON.parse(response);
                            } catch (error) {
                                alert('Erro ao interpretar a resposta do servidor.');
                                return;
                            }
                            
                            if (data.success) {
                                $('#ingrediente-' + id).fadeOut(300, function() {
                                    $(this).remove();
                                });
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function() {
                            alert('Ocorreu um erro ao tentar excluir o ingrediente.');
                        }
                    });
                }
            });
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
