<?php
include_once('verificaSessao.php');

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
    <style>
        /* Estilos para manter o layout consistente */
        .acoes {
            display: flex;
            gap: 10px;
        }
    </style>
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

    <h1>Itens de Estoque Cadastrados</h1>

    <div class="produto-cardapio">

        <?php if (count($itensestoque) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo Medida</th>
                        <th>Quantidade</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itensestoque as $t): ?>
                        <tr id="item-<?= $t['id'] ?>">
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
                                    onclick="excluirItem(<?= $t['id'] ?>)">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>

            <p style="text-align:center; margin-top:20px;">
                Nenhum item cadastrado.
            </p>

            <div class="container-btn">
                <button class="btn-cadastrar"
                    onclick="window.location.href='../html/cadastroItens.html'">
                    Cadastrar Item
                </button>
            </div>

        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar"
                onclick="window.location.href='../html/cadastroItens.html'">
                Cadastrar Outro Item
            </button>
        </div>
    </div>

    <script>
        async function excluirItem(id) {
            if (confirm('Tem certeza que deseja excluir este item?')) {
                try {
                    // Chama o arquivo PHP que você transformou em API JSON
                    const response = await fetch(`excluirItens.php?id=${id}`);
                    const data = await response.json();

                    if (data.status === 'success') {
                        alert(data.mensagem);
                        // Remove a linha da tabela sem recarregar a página inteira
                        const row = document.getElementById(`item-${id}`);
                        if (row) row.remove();
                        
                        // Opcional: recarregar se a tabela ficar vazia
                        if (document.querySelectorAll('tbody tr').length === 0) {
                            location.reload();
                        }
                    } else {
                        alert('Erro: ' + data.mensagem);
                    }
                } catch (error) {
                    console.error('Erro ao excluir:', error);
                    alert('Erro na comunicação com o servidor.');
                }
            }
        }
    </script>

</body>

</html>