<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php');

// Listagem unificada em MySQLi
$sql = "SELECT * FROM itensEstoque";
$result = $conexao->query($sql);

if (!$result) {
    die("Erro ao carregar dados: " . $conexao->error);
}

$itens = $result->fetch_all(MYSQLI_ASSOC);
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Lista de Itens</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/cadastrarItemEstoque.css">
    <style>
        .container-lista {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .topo-lista {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .topo-lista h1 {
            color: #333;
            font-size: 28px;
            margin: 0;
        }

        .btn-novo-insumo {
            background-color: #bfa15f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-novo-insumo:hover {
            background-color: #aa8f50;
        }

        .tabela-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        .tabela-moderna {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .tabela-moderna th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            padding: 14px 10px;
            border-bottom: 2px solid #eee;
            font-size: 14px;
        }

        .tabela-moderna td {
            padding: 14px 10px;
            border-bottom: 1px solid #eee;
            color: #444;
            font-size: 14px;
            vertical-align: middle;
            word-break: break-word; 
        }

        .tabela-moderna tbody tr:hover {
            background-color: #fdfdfd;
        }

        .col-id { width: 60px; }
        .col-nome { width: 250px; }
        .col-categoria { width: 140px; }
        .col-fornecedor { width: 180px; }
        .col-valor { width: 120px; }
        .col-minimo { width: 120px; }
        .col-acoes { width: 300px; text-align: center; }

        .btn-grupo {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-acao {
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-fluxo { background-color: #16a085; }
        .btn-fluxo:hover { background-color: #117a65; }

        .btn-alterar { background-color: #2c3e50; }
        .btn-alterar:hover { background-color: #1a252f; }

        .btn-excluir { background-color: #c0392b; }
        .btn-excluir:hover { background-color: #a93226; }
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
            <a href="listaItemEstoque.php" class="active">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="../php/aindaNao.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

    <main class="container-lista">
        <div class="topo-lista">
            <h1>Itens em Estoque</h1>
            <button class="btn-novo-insumo" onclick="window.location.href='formularioItemEstoque.php'">+ Novo Insumo</button>
        </div>

        <div class="tabela-card">
            <table class="tabela-moderna">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-nome">Nome do Item</th>
                        <th class="col-categoria">Categoria</th>
                        <th class="col-fornecedor">Fornecedor</th>
                        <th class="col-valor">Valor Unitário</th>
                        <th class="col-minimo">Estoque Mínimo</th>
                        <th class="col-acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($itens)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #7f8c8d;">Nenhum insumo cadastrado até o momento.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($itens as $i): ?>
                        <tr id="item-<?= $i['id'] ?>">
                            <td><?= $i['id'] ?></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($i['nomeItem']) ?> (<?= htmlspecialchars($i['tipoMedida'] ?? 'UN') ?>)</td>
                            <td><?= htmlspecialchars($i['categoria'] ?? 'Não definida') ?></td>
                            <td><?= htmlspecialchars($i['fornecedor']) ?></td>
                            <td>R$ <?= number_format($i['valorItem'], 2, ',', '.') ?></td>
                            <td style="color: #2c3e50; font-weight: bold;"><?= number_format($i['estoqueMinimo'], 2, ',', '.') ?></td>
                            <td>
                                <div class="btn-grupo">
                                    <button class="btn-acao btn-fluxo" onclick="window.location.href='../php/formFluxoItens.php?id=<?= $i['id'] ?>'">Fluxo</button>
                                    <button class="btn-acao btn-alterar" onclick="window.location.href='alterandoItemEstoque.php?id=<?= $i['id'] ?>'">Alterar</button>
                                    <button class="btn-acao btn-excluir" onclick="excluirItem(<?= $i['id'] ?>)">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    async function excluirItem(id) {
        if (confirm('Tem certeza de que deseja remover este item permanentemente?')) {
            try {
                const response = await fetch(`../php/excluindoItemEstoque.php?id=${id}`);
                
                if (!response.ok) {
                    const textoErro = await response.text();
                    alert(`Erro no Servidor (${response.status}): ${textoErro}`);
                    return;
                }

                const data = await response.json();
                if (data.status === 'success' || data.status === 'ok') {
                    document.getElementById(`item-${id}`).remove();
                    alert("Removido com sucesso!");
                } else {
                    alert(data.mensagem || "Erro ao excluir o item.");
                }
            } catch (e) { 
                alert("Erro ao comunicar com o servidor ou processar os dados."); 
                console.error(e);
            }
        }
    }
    </script>
</body>
</html>