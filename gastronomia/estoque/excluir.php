<?php
// Habilita a exibição de erros para facilitar a depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../includes/auth.php'; // Autenticação do usuário
require '../includes/db.php';   // Conexão com o banco de dados

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Iniciar uma transação
        $pdo->beginTransaction();
        
        // Primeiro, exclua as dependências na tabela estoque
        $deleteEstoque = $pdo->prepare("DELETE FROM estoque WHERE ingrediente_id = :id");
        $deleteEstoque->bindParam(':id', $id);
        $deleteEstoque->execute();
        
        // Depois, exclua o ingrediente
        $query = $pdo->prepare("DELETE FROM ingrediente WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        // Se tudo correr bem, confirme a transação
        $pdo->commit();

        // Resposta de sucesso
        echo json_encode(['success' => true, 'message' => 'Ingrediente excluído com sucesso!']);
    } catch (PDOException $e) {
        // Se ocorrer um erro, reverter a transação
        $pdo->rollBack();
        // Resposta de erro
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage()]);
    }
} else {
    // Se o ID não for passado, retorna um status 400
    echo json_encode(['success' => false, 'message' => 'Erro: ID não especificado.']);
}
?>
