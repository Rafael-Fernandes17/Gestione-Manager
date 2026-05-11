<?php
include_once('verificaSessao.php');
include_once('conexao.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Método de requisição inválido']);
    exit;
}


$nome = $_POST['nomeItem'] ?? null;
$quantidade = $_POST['quantidadeEstoque'] ?? null;
$unidade = $_POST['unidadeMedida'] ?? null;
$categoria = $_POST['categoria'] ?? null;

if (!$nome || !$quantidade || !$unidade || !$categoria) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Por favor, preencha todos os campos.']);
    exit;
}

if ($quantidade <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'A quantidade deve ser maior que zero.']);
    exit;
}

$stmt = $conexao->prepare("INSERT INTO itensestoque (nomeItem, tipoMedida, quantidadeUnitaria, categoria) VALUES (?, ?, ?, ?)");

$stmt->bind_param("ssds", $nome, $unidade, $quantidade, $categoria);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensagem' => 'Item cadastrado com sucesso!']);
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao cadastrar no banco: ' . $conexao->error]);
}

$stmt->close();
$conexao->close();
?>