<?php
include_once('verificaSessao.php');

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

$sql = "SELECT id, nomeItem, tipoMedida, categoria, fornecedor, valorItem, quantidadeUnitaria FROM produtosCardapio WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('Erro no prepare: ' . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<h3>Produto não encontrado.</h3>");
}

$produto = $result->fetch_assoc();
$stmt->close();

$idProdutoCardapio = htmlspecialchars($produto['id']);
$nomeProdutoCardapio = htmlspecialchars($produto['nomeProdutoCardapio']);
$descricao = htmlspecialchars($produto['descricao']);
$categoria = htmlspecialchars($produto['categoria']);
$tempoPreparo = htmlspecialchars($produto['tempoPreparo']);
$preco = htmlspecialchars($produto['preco']);
$tipoMedida = htmlspecialchars($produto['tipoMedida']);
$quantidade = htmlspecialchars($produto['quantidadeMedida']);
$status = htmlspecialchars($produto['statusProdutos']);
$imagem = $produto['imagem'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/editProdutosCardapio.css">
</head>

<body>
    <header>
        <a href="logout.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>

        <nav>
            <a href="../indexFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="../html/cadastroItens.html">ESTOQUE</a>
            <a href="../html/criandoProdutoCardapio.html">PRODUTOS</a>
            <a href="aindaNao.php">FINANCEIRO</a>
            <a href="aindaNao.php">RELATÓRIOS</a>
            <a href="cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

    <div class="container">
        <div class="form-card">
            <h2>Editar Produto</h2>

            <form method="POST" enctype="multipart/form-data">

                <label>ID:</label>
                <input type="text" value="<?= $idProdutoCardapio ?>" disabled>

                <label>Nome:</label>
                <input type="text" name="nomeProdutoCardapio" value="<?= $nomeProdutoCardapio ?>" required>

                <label>Descrição:</label>
                <textarea name="descricao"><?= $descricao ?></textarea>

                <label>Categoria:</label>
                <select name="categoria">
                    <option value="Entradas" <?= $categoria == 'Entradas' ? 'selected' : '' ?>>Entradas</option>
                    <option value="Pratos Principais" <?= $categoria == 'Pratos Principais' ? 'selected' : '' ?>>Pratos Principais</option>
                    <option value="Bebidas" <?= $categoria == 'Bebidas' ? 'selected' : '' ?>>Bebidas</option>
                    <option value="Sobremesas" <?= $categoria == 'Sobremesas' ? 'selected' : '' ?>>Sobremesas</option>
                </select>

                <label>Tempo:</label>
                <input type="time" name="tempoPreparo" value="<?= $tempoPreparo ?>" required>

                <label>Preço:</label>
                <input type="number" step="0.01" name="preco" value="<?= $preco ?>" required>

                <label>Imagem Atual:</label>

                <?php if (!empty($imagem)): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($imagem) ?>" width="120">


                <?php else: ?>
                    Sem imagem


                <?php endif; ?>

                <label>Alterar Imagem:</label>
                <input type="file" name="imagem">

                <label>Quantidade:</label>
                <input type="number" name="quantidadeMedida" value="<?= $quantidade ?>" required>

                <label>Tipo:</label>
                <select name="tipoMedida">
                    <option value="GM" <?= $tipoMedida == 'GM' ? 'selected' : '' ?>>GM</option>
                    <option value="ML" <?= $tipoMedida == 'ML' ? 'selected' : '' ?>>ML</option>
                    <option value="L" <?= $tipoMedida == 'L' ? 'selected' : '' ?>>L</option>
                </select>

                <label>Status:</label>
                <select name="statusProdutos">
                    <option value="Disponível" <?= $status == 'Disponível' ? 'selected' : '' ?>>Disponível</option>
                    <option value="Indisponível" <?= $status == 'Indisponível' ? 'selected' : '' ?>>Indisponível</option>
                </select>

                <button type="submit">Atualizar</button>

            </form>
        </div>
    </div>

</body>

</html>
php?>