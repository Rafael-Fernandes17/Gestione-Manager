<?php
$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao = $_POST["descricao"] ?? '';
    $categoria = $_POST["categoria"] ?? '';
    $tempoPreparo = $_POST["tempoPreparo"] ?? '';
    $preco = $_POST["preco"] ?? '';
    $quantidadeMedida = $_POST["quantidade"] ?? '';
    $tipoMedida = $_POST["tipoMedida"] ?? '';
    $statusProdutos = $_POST["statusProdutos"] ?? '';

    $preco = (float) str_replace(',', '.', $preco);

    if (
        empty($nomeProdutoCardapio) ||
        empty($descricao) ||
        empty($categoria) ||
        empty($tempoPreparo) ||
        empty($quantidadeMedida) ||
        empty($tipoMedida) ||
        empty($statusProdutos)
    ) {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    if (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== 0) {
        echo "Erro ao enviar imagem.";
        exit;
    }

    $imagem = file_get_contents($_FILES["imagem"]["tmp_name"]);

    if ($imagem === false) {
        echo "Erro ao ler a imagem.";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO produtosCardapio 
        (nomeProdutoCardapio, descricao, categoria, tempoPreparo, preco, imagem, quantidadeMedida, tipoMedida, statusProdutos)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die('Erro no prepare: ' . $conn->error);
    }

    $stmt->bind_param("ssssdsiss",
        $nomeProdutoCardapio,
        $descricao,
        $categoria,
        $tempoPreparo,
        $preco,
        $imagem,
        $quantidadeMedida,
        $tipoMedida,
        $statusProdutos
    );

    if ($stmt->execute()) {
        header("Location: readProdutoCardapio.php");
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>