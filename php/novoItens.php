<?php
include_once('conexao.php');

// O formulário continua enviando 'nome', 'quantidade' e 'unidade'
if(!isset($_POST['nome'], $_POST['quantidade'], $_POST['unidade'])){
    echo json_encode(['status' => 'nok', 'mensagem' => 'Dados não enviados']);
    exit;
}

$nome = $_POST['nome'];
$quantidade = (int) $_POST['quantidade'];
$unidade = $_POST['unidade'];
$categoria = "ingredientes"; // Valor padrão para o campo obrigatório do seu banco

if($quantidade <= 0){
    echo json_encode(['status' => 'nok', 'mensagem' => 'Quantidade deve ser maior que 0']);
    exit;
}

// AJUSTADO: Tabela 'itensestoque' e colunas conforme a imagem do seu banco


// ingrediente_novo.php
// Ajustado para a tabela 'itensEstoque' e colunas: nomeItem, tipoMedida, quantidadeUnitaria, categoria
$stmt = $conexao->prepare("INSERT INTO itensEstoque (nomeItem, tipoMedida, quantidadeUnitaria, categoria) VALUES (?, ?, ?, ?)");

// "ssis" -> nome(s), unidade(s), quantidade(i), categoria(s)
$categoria_padrao = "ingredientes"; 
$stmt->bind_param("ssis", $nome, $unidade, $quantidade, $categoria_padrao);




// s = string, i = inteiro. Ordem: nomeItem, tipoMedida, quantidadeUnitaria, categoria
$stmt->bind_param("ssis", $nome, $unidade, $quantidade, $categoria);
$stmt->execute();

if($stmt->affected_rows > 0){
    // Redireciona para a página de sucesso conforme solicitado anteriormente
    header("Location: ../sucesso.html");
    exit();
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro ao cadastrar: ' . $conexao->error]);
}

$stmt->close();
$conexao->close();
?>