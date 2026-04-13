<?php
include_once('verificaSessao.php');
include_once('conexao.php');

// O formulário continua enviando 'nome', 'quantidade' e 'unidade'
if(!isset($_POST['nome'], $_POST['quantidade'], $_POST['unidade'])){
    echo json_encode(['status' => 'nok', 'mensagem' => 'Dados não enviados']);
    exit;
}

$nome = $_POST['nome'];
$quantidade = (int) $_POST['quantidade'];
$unidade = $_POST['unidade'];
$categoria = $_POST["categoria"]; // Valor padrão para o campo obrigatório do seu banco

if($quantidade <= 0){
    echo json_encode(['status' => 'nok', 'mensagem' => 'Quantidade deve ser maior que 0']);
    exit;
}


// ingrediente_novo.php
// Ajustado para a tabela 'itensEstoque' e colunas: nomeItem, tipoMedida, quantidadeUnitaria, categoria
$stmt = $conexao->prepare("INSERT INTO itensestoque (nomeItem, tipoMedida, quantidadeUnitaria, categoria) VALUES (?, ?, ?, ?)");

// "ssis" -> nome(s), unidade(s), quantidade(i), categoria(s)
$stmt->bind_param("ssds", $nome, $unidade, $quantidade, $categoria);
$stmt->execute();

if($stmt->affected_rows > 0){
    echo json_encode(['status' => 'ok', 'mensagem' => 'Item cadastrado com sucesso!']);
    exit();
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao cadastrar: ' . $conexao->error]);
}

$stmt->close();
$conexao->close();
?>