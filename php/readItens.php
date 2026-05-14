<?php
<<<<<<< HEAD
include_once('verificaSessao.php');
include_once('conexao.php');
=======
require_once 'verificaPermissao.php'; 
verificaLogin(); 
>>>>>>> main

$sql = "SELECT * FROM itensEstoque";
$result = mysqli_query($conexao, $sql);
$itens = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Lista de Itens</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/readProdutosCardapio.css">
</head>
<body>
    <header>
        </header>

<<<<<<< HEAD
    <h1>Gestão de Itens e Limites</h1>
=======
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
>>>>>>> main

    <div class="produto-cardapio">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Fornecedor</th>
                    <th>Valor</th>
                    <th>Mínimo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $i): ?>
                <tr id="item-<?= $i['id'] ?>">
                    <td><?= $i['id'] ?></td>
                    <td><?= $i['nomeItem'] ?> (<?= $i['tipoMedida'] ?>)</td>
                    <td><?= $i['fornecedor'] ?></td>
                    <td>R$ <?= number_format($i['valorItem'], 2, ',', '.') ?></td>
                    <td style="color: #800020; font-weight: bold;"><?= $i['estoqueMinimo'] ?></td>
                    <td>
                        <button onclick="window.location.href='formFluxo.php?id=<?= $i['id']>'">Registrar Entrada/Saída</button>
                        <button onclick="window.location.href='getItens.php?id=<?= $i['id'] ?>'">Alterar</button>
                        <button onclick="excluirItem(<?= $i['id'] ?>)">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    async function excluirItem(id) {
        if (confirm('Deseja excluir?')) {
            const response = await fetch(`excluirItens.php?id=${id}`);
            const data = await response.json();
            if (data.status === 'success') {
                document.getElementById(`item-${id}`).remove();
                alert(data.mensagem);
            }
        }
    }
    </script>
</body>
</html>