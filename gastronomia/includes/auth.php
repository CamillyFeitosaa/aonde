<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão se não estiver já ativa
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>
