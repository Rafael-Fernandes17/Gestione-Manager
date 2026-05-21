<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
include_once('../php/conexao.php');

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("<h3>ID do produto não fornecido.</h3>");
}

$id = $_GET["id"];

if (!is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

// Remove ingredientes vinculados antes de excluir o produto
$stmt_ing = $conexao->prepare("DELETE FROM produto_ingrediente WHERE idProduto = ?");
$stmt_ing->bind_param("i", $id);
$stmt_ing->execute();
$stmt_ing->close();

$stmt = $conexao->prepare("DELETE FROM produtosCardapio WHERE idProdutosCardapio = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../view/listaProdutoCardapio.php?status=deleted_success");
    exit;
} else {
    header("Location: ../view/listaProdutoCardapio.php?status=deleted_error");
    exit;
}

$stmt->close();
$conexao->close();
?>