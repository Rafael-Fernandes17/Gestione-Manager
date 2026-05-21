<?php
require_once '../php/verificaPermissao.php';
verificaLogin();

$conn = new mysqli('localhost:3307', 'root', '', 'gestione_manager');

if ($conn->connect_error) {
    die("<h3>Erro ao conectar ao banco de dados.</h3>");
}

$sql = "SELECT * FROM produtosCardapio";
$result = $conn->query($sql);

$produtosCardapio = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtosCardapio[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Produtos do Cardápio</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/listaProdutosCardapio.css">
</head>
<body>

    <header>
        <a href="logout.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>
        <nav>
            <a href="paginaPrincipalFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php" class="active">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="paginaRelatorios.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'">Logout</button>
        </nav>
    </header>

    <h1>Produtos do Cardápio Cadastrados</h1>

    <div class="produto-cardapio">

        <?php if (count($produtosCardapio) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Tempo</th>
                        <th>Preço</th>
                        <th>Imagem</th>
                        <th>Medida</th>
                        <th>Qtd</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtosCardapio as $p): ?>
                        <tr>
                            <td><?= $p['idProdutosCardapio'] ?></td>
                            <td><?= htmlspecialchars($p['nomeProdutoCardapio']) ?></td>
                            <td><?= htmlspecialchars($p['descricao']) ?></td>
                            <td><?= htmlspecialchars($p['categoria']) ?></td>
                            <td><?= htmlspecialchars($p['tempoPreparo']) ?></td>
                            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                            <td>
                                <?php if (!empty($p['imagem'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($p['imagem']) ?>" width="80">
                                <?php else: ?>
                                    Sem imagem
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['tipoMedida']) ?></td>
                            <td><?= htmlspecialchars($p['quantidadeMedida']) ?></td>
                            <td><?= htmlspecialchars($p['statusProdutos']) ?></td>
                            <td class="acoes">
                                <button class="btn-editar"
                                    onclick="window.location.href='alterandoProdutoCardapio.php?id=<?= $p['idProdutosCardapio'] ?>'">
                                    Alterar
                                </button>
                                <button class="btn-editar"
                                    onclick="window.location.href='adicionandoCustoProduto.php?idProduto=<?= $p['idProdutosCardapio'] ?>'">
                                    Definir Preço
                                </button>
                                <button class="btn-excluir"
                                    onclick="if(confirm('Tem certeza?')) window.location.href='../php/excluindoProdutoCardapio.php?id=<?= $p['idProdutosCardapio'] ?>'">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p style="text-align:center; margin-top:20px;">Nenhum produto cadastrado.</p>
        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar"
                onclick="window.location.href='formularioProdutoCardapio.php'">
                Cadastrar Produto
            </button>
            <button class="btn-cadastrar"
                onclick="window.location.href='cardapio.php'">
                Visualizar Cardápio
            </button>
        </div>

        

    </div>

</body>
</html>