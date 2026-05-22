<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
verificaAdm();
include_once('../php/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProduto  = $_POST["idProduto"] ?? '';
    $precoFinal = $_POST["precoFinal"] ?? '';

    if (!is_numeric($idProduto) || !is_numeric($precoFinal) || (float)$precoFinal < 0) {
        header("Location: ../view/listaProdutoCardapio.php?status=error_preco");
        exit;
    }

    $status = "Disponível";
    $stmt = $conexao->prepare("UPDATE produtoCardapio SET preco = ?, statusProdutos = ? WHERE idProdutosCardapio = ?");
    $stmt->bind_param("dsi", $precoFinal, $status, $idProduto);

    if ($stmt->execute()) {
        header("Location: ../view/listaProdutoCardapio.php?status=preco_success");
        exit;
    } else {
        header("Location: ../view/listaProdutoCardapio.php?status=error_preco");
        exit;
    }

    $stmt->close();
}

$conexao->close();
?>