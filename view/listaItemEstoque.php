<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php');

$itens = [];

$resultado = $conexao->query("SELECT * FROM itensEstoque");

if (!$resultado) {
    die("Erro ao carregar dados: " . $conexao->error);
}

while ($row = $resultado->fetch_assoc()) {
    $itens[] = $row;
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Lista de Itens</title>
    <link rel="stylesheet" href="../css/listaProdutosCardapio.css">
    <style>
        .btn-registro {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }
        .btn-registro:hover {
            background-color: #1a252f;
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
            <a href="paginaPrincipalFuncionario.php">HOME</a>
            <a href="../php/aindaNao.php">DASHBOARD</a>
            <a href="../php/aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="../php/aindaNao.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </header>

    <h1>Itens de Estoque Cadastrados</h1>

    <div class="produto-cardapio">

        <?php if (!empty($itens)): ?>
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
                    <td><?= htmlspecialchars($i['nomeItem']) ?> (<?= htmlspecialchars($i['tipoMedida']) ?>)</td>
                    <td><?= htmlspecialchars($i['fornecedor']) ?></td>
                    <td>R$ <?= number_format($i['valorItem'], 2, ',', '.') ?></td>
                    <td style="color: #800020; font-weight: bold;"><?= $i['estoqueMinimo'] ?></td>
                    <td class="acoes">
                        <button class="btn-registro" onclick="window.location.href='formFluxoItens.php?id=<?= $i['id'] ?>'">
                            Registro de Entrada/Saída
                        </button>
                        <button class="btn-editar" onclick="window.location.href='alterandoItemEstoque.php?id=<?= $i['id'] ?>'">Alterar</button>
                        <button class="btn-excluir" onclick="excluirItem(<?= $i['id'] ?>)">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php else: ?>
            <p style="text-align:center; margin-top:20px;">Nenhum item cadastrado.</p>
        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar" onclick="window.location.href='../view/formularioItemEstoque.php'">
                Cadastrar Item
            </button>
        </div>

    </div>

    <script>
    async function excluirItem(id) {
        if (confirm('Deseja excluir?')) {
            try {
                const response = await fetch(`excluirItens.php?id=${id}`);
                const data = await response.json();
                if (data.status === 'success' || data.status === 'ok') {
                    document.getElementById(`item-${id}`).remove();
                    alert("Removido com sucesso!");
                }
            } catch (e) { alert("Erro ao comunicar com o servidor."); }
        }
    }
    </script>
</body>
</html>