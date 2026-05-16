<?php
require_once 'verifyPermissao.php'; 
verificaLogin(); 
include_once('connection.php');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID não fornecido']);
    exit;
}

try {
    $stmt = $connection->prepare("DELETE FROM itensEstoque WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['status' => 'success', 'mensagem' => 'Item removido!']);
    } else {
        echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'mensagem' => $e->getMessage()]);
}
?>