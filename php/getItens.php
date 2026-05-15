<?php
require_once 'verificaPermissao.php';
verificaLogin(); 
include_once('conexao.php');

$id = $_GET['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Content-Type: application/json');
    try {
        $stmt = $conexao->prepare("SELECT * FROM itensEstoque WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'dados' => $item]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'mensagem' => $e->getMessage()]);
    }
    exit;
}
?>