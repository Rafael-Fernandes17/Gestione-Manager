<?php
include_once('verificaSessao.php');
include_once('conexao.php');

header('Content-Type: application/json');

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID inválido']);
    exit;
}

$stmt = $conexao->prepare("DELETE FROM itensestoque WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'mensagem' => 'Item excluído com sucesso']);
} else {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir']);
}

$stmt->close();
$conexao->close();
?>