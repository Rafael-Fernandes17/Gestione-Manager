<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php');

header('Content-Type: application/json');

$idItem        = $_POST['idItem'] ?? ''; 
$nome          = trim($_POST['nome'] ?? '');
$unidade       = $_POST['unidade'] ?? '';
$categoria     = $_POST['categoria'] ?? '';
$fornecedor    = $_POST['fornecedor'] ?? '';
$valor         = isset($_POST['valor']) ? (float)$_POST['valor'] : 0.0;
$estoqueMinimo = isset($_POST['estoqueMinimo']) ? (float)$_POST['estoqueMinimo'] : 0.0;

// Trava de segurança do servidor contra campos vazios
if (empty($nome)) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro: O campo nome não pode estar vazio.']);
    exit;
}

// Trava de segurança rigorosa para o VALOR no PHP
if ($valor <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro: O valor precisa ser maior que zero.']);
    exit;
}

// Trava de segurança rigorosa para o ESTOQUE MÍNIMO no PHP
if ($estoqueMinimo <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro: O estoque mínimo precisa ser maior que zero.']);
    exit;
}

if (!empty($idItem) && is_numeric($idItem)) {
    // Modo Alteração
    $sql = "UPDATE itensEstoque SET nomeItem = ?, tipoMedida = ?, categoria = ?, fornecedor = ?, valorItem = ?, estoqueMinimo = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'Erro na preparação da alteração: ' . $conexao->error]);
        exit;
    }
    $stmt->bind_param("ssssddi", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo, $idItem);
    $mensagemSucesso = 'Item atualizado com sucesso!';
} else {
    // Modo Cadastro
    $sql = "INSERT INTO itensEstoque (nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'Erro na preparação do cadastro: ' . $conexao->error]);
        exit;
    }
    $stmt->bind_param("ssssdd", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo);
    $mensagemSucesso = 'Item cadastrado com sucesso!';
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensagem' => $mensagemSucesso]);
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao salvar no banco: ' . $stmt->error]);
}

$stmt->close();
$conexao->close();
?>