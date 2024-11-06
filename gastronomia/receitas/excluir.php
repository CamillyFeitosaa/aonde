<?php
require '../includes/db.php'; // Incluindo a conexão com o banco de dados

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Começar uma transação
        $pdo->beginTransaction();

        // Excluir todos os ingredientes relacionados
        $stmt = $pdo->prepare("DELETE FROM receita_ingrediente WHERE receita_id = :id");
        $stmt->execute(['id' => $id]);

        // Excluir a receita
        $stmt = $pdo->prepare("DELETE FROM receita WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Comitar a transação
        $pdo->commit();

        echo "Receita excluída com sucesso!";
    } catch (PDOException $e) {
        // Se algo falhar, reverter a transação
        $pdo->rollBack();
        echo "Erro ao excluir receita: " . $e->getMessage();
    }
} else {
    echo "ID da receita não fornecido.";
}
?>
