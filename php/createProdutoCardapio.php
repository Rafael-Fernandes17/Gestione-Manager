<?php

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if(!$conn) {
    die('Erro na coneção: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao = $_POST["descricao"] ?? '';
    $tempoPreparo = $_POST["tempoPreparo"] ?? '';
    $preco = $_POST["preco"] ?? '';
    $tipoMedida = $_POST["tipoMedida"] ?? '';
    $quantidade = $_POST["quantidade"] ?? '';
    $status = $_POST["status"] ?? '';

    if (
        empty($nomeProdutoCardapio) || empty($descricao) || empty($tempoPreparo) || empty($preco) ||
        empty($tipoMedida) || empty($quantidade) || empty($status)
    ) {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO produtosCardapio (nomeProdutoCardapio, descricao, tempoPreparo, preco, tipoMedida, quantidade, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    if(!$stmt){
        die('Erro no prepare: ' . $conn->error);
    }

    $stmt->bind_param("sstiee", $nomeProdutoCardapio, $descricao, $tempoPreparo, $preco, $tipoMedida, $quantidade, $status);

    if($stmt->execute()){
        $id_gerado = mysqli_insert_id($conn);
        echo "Produto cadastrado com sucesso! ID: $id_gerado";
        header("Location: getProdutosCardapio.php?id=$id_gerado");
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>