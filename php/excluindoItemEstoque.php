<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php');

header('Content-Type: application/json');

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID não fornecido']);
    exit;
}

$stmt = $conexao->prepare("DELETE FROM itensEstoque WHERE id = ?");

if (!$stmt) {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao preparar query: ' . $conexao->error]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'mensagem' => 'Item removido!']);
} else {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir: ' . $stmt->error]);
}

$stmt->close();
?>