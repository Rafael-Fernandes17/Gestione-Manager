<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php');

header('Content-Type: application/json');

// Captura o ID vindo da URL de forma segura
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID não fornecido ou inválido.']);
    exit;
}

// CORREÇÃO: Alterado de 'idItensEstoque' para 'id', combinando com sua tabela oficial do banco
$stmt = $conexao->prepare("DELETE FROM itensEstoque WHERE id = ?");

if (!$stmt) {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao preparar query: ' . $conexao->error]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Retorna o status de sucesso esperado pelo JavaScript
    echo json_encode(['status' => 'success', 'mensagem' => 'Item removido com sucesso!']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir no banco: ' . $stmt->error]);
    exit;
}

$stmt->close();
$conexao->close();
?>