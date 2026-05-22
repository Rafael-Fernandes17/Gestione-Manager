<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
include_once('../php/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao           = $_POST["descricao"] ?? '';
    $categoria           = $_POST["categoria"] ?? '';
    $tempoPreparo        = $_POST["tempoPreparo"] ?? '';
    $quantidadeMedida    = $_POST["quantidade"] ?? '';
    $tipoMedida          = $_POST["tipoMedida"] ?? '';
    $preco               = 0.00;
    $statusProdutos      = 'Indisponível';

    $imagem = null;
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
        $imagem = file_get_contents($_FILES["imagem"]["tmp_name"]);
    }

    $stmt = $conexao->prepare("INSERT INTO produtoCardapio (
        nomeProdutoCardapio, descricao, categoria, tempoPreparo,
        preco, imagem, quantidadeMedida, tipoMedida, statusProdutos
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssdbiss",
        $nomeProdutoCardapio, $descricao, $categoria, $tempoPreparo,
        $preco, $imagem, $quantidadeMedida, $tipoMedida, $statusProdutos
    );

    if ($imagem !== null) {
        $stmt->send_long_data(5, $imagem);
    }

    if ($stmt->execute()) {
        $idProduto = $conexao->insert_id;

        if (isset($_POST["itensEstoque"]) && is_array($_POST["itensEstoque"]) && !empty($_POST["itensEstoque"])) {
            $stmt_ing = $conexao->prepare("INSERT INTO produto_ingrediente (idProduto, idItemEstoque) VALUES (?, ?)");
            $stmt_ing->bind_param("ii", $idProduto, $idItemEstoque);

            foreach ($_POST["itensEstoque"] as $idItemEstoque) {
                if (!$stmt_ing->execute()) {
                    echo "Erro ao associar ingrediente ID " . htmlspecialchars($idItemEstoque) . ": " . $stmt_ing->error;
                }
            }
            $stmt_ing->close();
        }

        header("Location: ../view/listaProdutoCardapio.php?status=success");
        exit;
    } else {
        header("Location: ../view/listaProdutoCardapio.php?status=error");
        exit;
    }

    $stmt->close();
}

$conexao->close();
?>