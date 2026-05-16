<?php
require_once 'verifyPermissao.php'; // Alterado de verificaSessao
verificaLogin(); 
include_once('connection.php');

header('Content-Type: application/json');

$nome          = $_POST['nome'] ?? '';
$unidade       = $_POST['unidade'] ?? '';
$categoria     = $_POST['categoria'] ?? '';
$fornecedor    = $_POST['fornecedor'] ?? '';
$valor         = $_POST['valor'] ?? 0;
$estoqueMinimo = $_POST['estoqueMinimo'] ?? 0;

if (empty($nome) || $estoqueMinimo <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Preencha os campos obrigatórios.']);
    exit;
}

try {
    // Usando padrão PDO para aceitar sua connection.php
    $sql = "INSERT INTO itensEstoque (nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if ($stmt->execute([$nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo])) {
        echo json_encode(['status' => 'ok', 'mensagem' => 'Item salvo com sucesso!']);
    } else {
        echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao salvar no banco.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro: ' . $e->getMessage()]);
}
?>