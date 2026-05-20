<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin();    

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
    <title>Produtos do Cardápio</title>
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
            <a href="../php/aindaNao.php">DASHBOARD</a>
            <a href="../php/aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="../php/aindaNao.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

    <h1>Produtos do Cardápio Cadastrados</h1>

    <div class="produto-cardapio">

        <?php if (count($produtosCardapio) > 0): ?>

            <table>
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

                <?php foreach ($produtosCardapio as $p): ?>
                    <tr>
                        <td><?= $p['idProdutosCardapio'] ?></td>
                        <td><?= $p['nomeProdutoCardapio'] ?></td>
                        <td><?= $p['descricao'] ?></td>
                        <td><?= $p['categoria'] ?></td>
                        <td><?= $p['tempoPreparo'] ?></td>
                        <td>R$ <?= $p['preco'] ?></td>

                        <td>
                            <?php
                            if (!empty($p['imagem'])) {
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mime = $finfo->buffer($p['imagem']);
                                echo '<img src="data:' . $mime . ';base64,' . base64_encode($p['imagem']) . '" width="80">';
                            } else {
                                echo "Sem imagem";
                            }
                            ?>
                        </td>

                        <td><?= $p['tipoMedida'] ?></td>
                        <td><?= $p['quantidadeMedida'] ?></td>
                        <td><?= $p['statusProdutos'] ?></td>

                        <td class="acoes">
                            <button class="btn-editar"
                                onclick="window.location.href='alterandoProdutoCardapio.php?id=<?= $p['idProdutosCardapio'] ?>'">
                                Alterar
                            </button>

                            <button class="btn-excluir"
                                onclick="if(confirm('Tem certeza?')) window.location.href='../php/excluindoProdutoCardapio.php?id=<?= $p['idProdutosCardapio'] ?>'">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p style="text-align:center; margin-top:20px;">
                Nenhum produto cadastrado.
            </p>

            <div class="container-btn">
                <button class="btn-cadastrar"
                    onclick="window.location.href='formularioProdutoCardapio.php'">
                    Cadastrar Produto
                </button>
            </div>

        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar"
                onclick="window.location.href='formularioProdutoCardapio.php'">
                Cadastrar Outro Produto
            </button>
        </div>

        <button class="btn-cadastrar"
            onclick="window.location.href='cardapio.php'">
            Visualizar Cardápio
        </button>

    </div>

</body>

</html>