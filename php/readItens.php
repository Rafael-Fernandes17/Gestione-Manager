<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die("<h3>Erro ao conectar ao banco de dados.</h3>");
}

$sql = "SELECT * FROM itensestoque";
$result = mysqli_query($conn, $sql);

$itensestoque = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $itensestoque[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Itens de Estoque</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/readProdutosCardapio.css">
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
            <a href="../view/cadastroItens.php">ESTOQUE</a>
            <a href="../view/criandoProdutoCardapio.php">PRODUTOS</a>
            <a href="aindaNao.php">FINANCEIRO</a>
            <a href="aindaNao.php">RELATÓRIOS</a>
            <a href="../view/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

    <h1>Itens de Estoque Cadastrados</h1>

    <div class="produto-cardapio">

        <?php if (count($itensestoque) > 0): ?>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo Medida</th>
                    <th>Quantidade</th>
                    <th>Categoria</th>
                </tr>

                <?php foreach ($itensestoque as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= $t['nomeItem'] ?></td>
                        <td><?= $t['tipoMedida'] ?></td>
                        <td><?= $t['quantidadeUnitaria'] ?></td>
                        <td><?= $t['categoria'] ?></td>


                        <td class="acoes">
                            <button class="btn-editar"
                                onclick="window.location.href='getItens.php?id=<?= $t['id'] ?>'">
                                Alterar
                            </button>

                            <button class="btn-excluir"
                                onclick="if(confirm('Tem certeza?')) window.location.href='excluirItens.php?id=<?= $t['id'] ?>'">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p style="text-align:center; margin-top:20px;">
                Nenhum item cadastrado.
            </p>

            <div class="container-btn">
                <button class="btn-cadastrar"
                    onclick="window.location.href='../html/cadastroItens'">
                    Cadastrar Item
                </button>
            </div>

        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar"
                onclick="window.location.href='../html/cadastroItens'">
                Cadastrar Outro Item
            </button>
        </div>
    </div>

</body>

</html>