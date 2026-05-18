<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

<<<<<<< HEAD
if (!$id) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID não fornecido']);
=======
$id = $_GET["id"];

if (!is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}


$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

$sql = "DELETE FROM itensestoque WHERE idItensEstoque = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('Erro no prepare: ' . $conn->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redireciona de volta para a página de leitura com uma mensagem de sucesso
    header("Location: readItens.php?status=deleted_success");
    exit;
} else {
    // Redireciona de volta para a página de leitura com uma mensagem de erro
    header("Location: readItens.php?status=deleted_error");
>>>>>>> 2cd921ff9c87c95fd64f22f86014260427eda96d
    exit;
}

try {
    $stmt = $conexao->prepare("DELETE FROM itensEstoque WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['status' => 'success', 'mensagem' => 'Item removido!']);
    } else {
        echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao excluir.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'mensagem' => $e->getMessage()]);
}
?>