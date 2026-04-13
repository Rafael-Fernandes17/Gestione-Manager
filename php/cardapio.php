<?php
$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die("<h3>Erro ao conectar ao banco de dados.</h3>");
}

$sql = "SELECT * FROM produtosCardapio";
$result = mysqli_query($conn, $sql);

$produtosCardapio = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produtosCardapio[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gestione</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/cardapio.css">
    <script src="../js/cardapio.js"></script>
</head>

<body>

<div class="layout">

    
    <aside class="sidebar">
        <img src="../imagens/Logo1.png" alt="Logo" class="logo">

        <nav>
            <button data-categoria="entradas">Entradas</button>
            <button data-categoria="pratos principais" class="active">Pratos Principais</button>
            <button data-categoria="bebidas">Bebidas</button>
            <button data-categoria="sobremesas">Sobremesas</button>
        </nav>
    </aside>

    <div class="conteudo">
        <header>
            <h1>CARDÁPIO DIGITAL</h1>
        </header>

        <main id="menu">

            <?php if (count($produtosCardapio) > 0): ?>

                <?php foreach ($produtosCardapio as $produto): ?>

                    <div class="card" data-categoria="<?= strtolower($produto['categoria']) ?>">

                        <?php if (!empty($produto['imagem'])): ?>
                            <?php $imagemBase64 = base64_encode($produto['imagem']); ?>
                            <img src="data:image/jpeg;base64,<?= $imagemBase64 ?>" alt="Imagem">
                        <?php else: ?>
                            <p>Sem imagem</p>
                        <?php endif; ?>

                        <div class="info">
                            <h2><?= htmlspecialchars($produto['nomeProdutoCardapio']) ?></h2>

                            <p class="descricao">
                                <?= htmlspecialchars($produto['descricao']) ?>
                            </p>

                            <div class="rodape">
                                <span class="preco">
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </span>

                                <span class="tempo">
                                    ⏱ <?= substr($produto['tempoPreparo'], 0, 5) ?>
                                </span>
                            </div>

                            <span class="status <?= $produto['statusProdutos'] == 'Disponível' ? 'ativo' : 'inativo' ?>">
                                <?= htmlspecialchars($produto['statusProdutos']) ?>
                            </span>
                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <p style="text-align:center;">Nenhum produto cadastrado.</p>
            <?php endif; ?>

        </main>
    </div>

</div>


</body>
</html>