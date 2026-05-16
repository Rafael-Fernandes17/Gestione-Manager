<?php

$servidor = 'localhost:3307';
$usuario = 'root';
$senha = '';
$nome_banco = 'gestione_manager';

try {
    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$nome_banco;charset=utf8",
        $usuario,
        $senha
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro na conexão: ' . $e->getMessage()]);
    exit;
}
?>