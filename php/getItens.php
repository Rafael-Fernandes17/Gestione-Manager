<?php
include_once('conexao.php');

header("Content-Type: application/json");

// AJUSTADO: Nome da tabela para itensestoque
$stmt = $conexao->prepare("SELECT * FROM itensestoque");
$stmt->execute();
$resultado = $stmt->get_result();

$tabela = [];

while($linha = $resultado->fetch_assoc()){
    $tabela[] = $linha;
}

echo json_encode([
    'status' => 'ok',
    'data' => $tabela
]);
?>