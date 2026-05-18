<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 
include_once('conexao.php');

try {
    $sql = "SELECT * FROM itensEstoque";
    $stmt = $conexao->query($sql);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Lista de Itens</title>
    <link rel="stylesheet" href="../css/readProdutosCardapio.css">
    <style>
        /* Estilo rápido para o novo botão se destacar dos outros */
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
    <h1>Gestão de Itens e Limites</h1>
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
                    <td><?= htmlspecialchars($i['nomeItem']) ?> (<?= htmlspecialchars($i['tipoMedida']) ?>)</td>
                    <td><?= htmlspecialchars($i['fornecedor']) ?></td>
                    <td>R$ <?= number_format($i['valorItem'], 2, ',', '.') ?></td>
                    <td style="color: #800020; font-weight: bold;"><?= $i['estoqueMinimo'] ?></td>
                    <td class="acoes">
                       <button class="btn-registro" onclick="window.location.href='formFluxoItens.php?id=<?= $i['id'] ?>'">
                        Registro de Entrada/Saída
                    </button>
                                            
                        <button class="btn-editar" onclick="window.location.href='getItens.php?id=<?= $i['id'] ?>'">Alterar</button>
                        <button class="btn-excluir" onclick="excluirItem(<?= $i['id'] ?>)">Excluir</button>
                    </td>
                </tr>
<<<<<<< HEAD
                <?php endforeach; ?>
            </tbody>
        </table>
=======

                <?php foreach ($itensestoque as $t): ?>
                    <tr>
                        <td><?= $t['idItensEstoque'] ?></td>
                        <td><?= $t['nomeItem'] ?></td>
                        <td><?= $t['tipoMedida'] ?></td>
                        <td><?= $t['quantidadeUnitaria'] ?></td>
                        <td><?= $t['categoria'] ?></td>


                        <td class="acoes">
                            <button class="btn-editar" onclick="window.location.href='getItens.php?id=<?= $t['idItensEstoque'] ?>'">
                                Alterar
                            </button>

                            <button class="btn-excluir"
                                onclick="if(confirm('Tem certeza?')) window.location.href='excluirItens.php?id=<?= $t['idItensEstoque'] ?>'">
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
                    onclick="window.location.href='../view/cadastroItens.php'">
                    Cadastrar Item
                </button>
            </div>

        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar"
                onclick="window.location.href='../view/cadastroItens.php'">
                Cadastrar Outro Item
            </button>
        </div>
>>>>>>> 2cd921ff9c87c95fd64f22f86014260427eda96d
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