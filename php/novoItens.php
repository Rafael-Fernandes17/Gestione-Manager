<?php
include_once('verificaSessao.php');
include_once('conexao.php');
header('Content-Type: application/json');

$nome = $_POST['nome'] ?? '';
$unidade = $_POST['unidade'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$fornecedor = $_POST['fornecedor'] ?? '';
$valor = $_POST['valor'] ?? 0;
$estoqueMinimo = $_POST['estoqueMinimo'] ?? 0;

$stmt = $conexao->prepare("INSERT INTO itensEstoque (nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo) VALUES (?, ?, ?, ?, ?, ?)");
// sssddd -> string, string, string, decimal, decimal, decimal
$stmt->bind_param("ssssdd", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensagem' => 'Item configurado com sucesso!']);
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao salvar: ' . $conexao->error]);
}
?>