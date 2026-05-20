<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php'); // Usa a sua conexão padrão do sistema

// Define que a resposta será um JSON bem estruturado
header('Content-Type: application/json');

// Recebe os dados enviados pelo seu JavaScript
$idItem        = $_POST['idItem'] ?? ''; 
$nome          = $_POST['nome'] ?? '';
$unidade       = $_POST['unidade'] ?? '';
$categoria     = $_POST['categoria'] ?? '';
$fornecedor    = $_POST['fornecedor'] ?? '';
$valor         = $_POST['valor'] ?? 0;
$estoqueMinimo = $_POST['estoqueMinimo'] ?? 0;

// Validação de segurança no servidor
if (empty($nome) || $estoqueMinimo <= 0) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro: Preencha os campos obrigatórios (Nome e Estoque Mínimo).']);
    exit;
}

// INTEGRAÇÃO INTELIGENTE: Se existir ID, altera. Se não, cadastra novo!
if (!empty($idItem) && is_numeric($idItem)) {
    
    // MODO ALTERAÇÃO (UPDATE)
    $sql = "UPDATE itensEstoque SET nomeItem = ?, tipoMedida = ?, categoria = ?, fornecedor = ?, valorItem = ?, estoqueMinimo = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'Erro na preparação da alteração: ' . $conexao->error]);
        exit;
    }
    
    // O "i" no final do "ssssddi" representa o ID que é um número Inteiro
    $stmt->bind_param("ssssddi", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo, $idItem);
    $mensagemSucesso = 'Item atualizado com sucesso!';

} else {
    
    // MODO CADASTRO DO ZERO (INSERT)
    $sql = "INSERT INTO itensEstoque (nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'Erro na preparação do cadastro: ' . $conexao->error]);
        exit;
    }
    
    $stmt->bind_param("ssssdd", $nome, $unidade, $categoria, $fornecedor, $valor, $estoqueMinimo);
    $mensagemSucesso = 'Item cadastrado com sucesso do zero!';
}

// Executa a query no banco de dados
if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensagem' => $mensagemSucesso]);
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao salvar os dados: ' . $stmt->error]);
}

$stmt->close();
$conexao->close();
?>