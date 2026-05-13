<?php
include_once('verificaSessao.php');

// Conexão - Ajuste a porta se necessário (3306 ou 3307)
$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die("<h3>Erro ao conectar ao banco de dados.</h3>");
}

// SQL atualizado para incluir Fornecedor e Valor do Item
$sql = "SELECT id, nomeItem, tipoMedida, categoria, fornecedor, valorItem, estoqueMinimo FROM itensEstoque";
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
    <title>Gestione Manager - Inventário e Limites</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/readProdutosCardapio.css">
    <style>
        /* Estilo para destacar os valores e alertas */
        .valor-dinheiro {
            color: #2e7d32; /* Verde para valores */
            font-weight: bold;
        }

        .minimo-alerta {
            color: #800020; /* Vinho */
            font-weight: bold;
        }

        .acoes {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        /* Hover na linha para facilitar leitura */
        table tbody tr:hover {
            background-color: #f9f9f9;
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
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

    <h1>Gestão de Insumos e Limites Mínimos</h1>

    <div class="produto-cardapio">

        <?php if (count($itensestoque) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Preço Unit.</th>
                        <th>Mínimo (Alerta)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itensestoque as $t): ?>
                        <tr id="item-<?= $t['id'] ?>">
                            <td><?= $t['id'] ?></td>
                            <td style="text-align: left; padding-left: 15px;">
                                <strong><?= htmlspecialchars($t['nomeItem']) ?></strong>
                                <br><small style="color: #666;"><?= htmlspecialchars($t['tipoMedida']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($t['categoria']) ?></td>
                            <td><?= htmlspecialchars($t['fornecedor']) ?></td>
                            <td class="valor-dinheiro">R$ <?= number_format($t['valorItem'], 2, ',', '.') ?></td>
                            <td class="minimo-alerta"><?= $t['estoqueMinimo'] ?></td>

                            <td class="acoes">
                                <button class="btn-editar" 
                                    onclick="window.location.href='getItens.php?id=<?= $t['id'] ?>'" title="Editar Configuração">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                </button>

                                <button class="btn-excluir" 
                                    onclick="excluirItem(<?= $t['id'] ?>)" title="Excluir Item">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p style="text-align:center; margin-top:30px; font-size: 1.2em; color: #666;">
                Nenhum item configurado no sistema.
            </p>
        <?php endif; ?>

        <div class="container-btn">
            <button class="btn-cadastrar" 
                onclick="window.location.href='../html/cadastroItens.html'">
                + Configurar Novo Insumo
            </button>
        </div>
    </div>

    <script>
    async function excluirItem(id) {
        if (confirm('Deseja realmente remover este item do inventário?')) {
            try {
                // Chama o script PHP que processa e retorna JSON
                const response = await fetch(`excluirItens.php?id=${id}`);
                const data = await response.json();

                if (data.status === 'success' || data.status === 'ok') {
                    alert(data.mensagem);
                    
                    // Efeito visual de remoção
                    const linha = document.getElementById(`item-${id}`);
                    if (linha) {
                        linha.style.transition = "all 0.4s ease";
                        linha.style.opacity = "0";
                        linha.style.transform = "translateX(20px)";
                        setTimeout(() => linha.remove(), 400);
                    }
                } else {
                    alert('Erro: ' + data.mensagem);
                }
            } catch (error) {
                console.error('Erro na requisição:', error);
                alert('Erro ao conectar com o servidor.');
            }
        }
    }
    </script>

</body>
</html>