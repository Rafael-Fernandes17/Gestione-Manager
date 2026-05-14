<?php
require_once 'verificaPermissao.php'; 
require_once 'conexao.php';
verificaLogin(); 

header('Content-Type: application/json');

$nome = $_POST['nome'] ?? '';
$unidade = $_POST['unidade'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$fornecedor = $_POST['fornecedor'] ?? '';
$valor = $_POST['valor'] ?? 0;
$estoqueMinimo = $_POST['estoqueMinimo'] ?? 0;

// Proteção básica contra valores vazios
if(empty($nome) || $estoqueMinimo <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Preencha os campos corretamente (Mínimo > 0).']);
    exit;
}

$stmt = $conexao->prepare("INSERT INTO itensEstoque (nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssdd", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensagem' => 'Item e estoque mínimo registrados com sucesso!']);
} else {
<<<<<<< HEAD
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro no banco: ' . $conexao->error]);
=======
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao cadastrar: ' . $conexao->error]);
    exit();
>>>>>>> main
}
$stmt->close();
$conexao->close();
?>