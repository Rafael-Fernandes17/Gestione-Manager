<?php
<<<<<<< HEAD
include_once('verificaSessao.php');
include_once('conexao.php');
header('Content-Type: application/json');
=======
require_once 'verificaPermissao.php'; 
verificaLogin(); 
>>>>>>> main

$id = $_GET['id'] ?? null;
$stmt = $conexao->prepare("DELETE FROM itensEstoque WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'mensagem' => 'Item removido!']);
} else {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir.']);
}
?>