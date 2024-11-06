<?php
$host = 'localhost';      // Endereço do servidor MySQL
$user = 'root';           // Usuário MySQL
$password = '';           // Senha MySQL (em ambientes locais, pode estar vazia)
$dbname = 'gastronomia'; // Nome do banco de dados

// Criar a conexão
$pdo = new mysqli($host, $user, $password, $dbname);

// Verificar se a conexão falhou
if ($pdo->connect_error) {
    die('Conexão falhou: ' . $pdo->connect_error);
}
?>
