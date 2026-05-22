<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
verificaAdm();
include_once('../php/conexao.php');

$historicoEntradas = [];

$sql = "SELECT 
            fe.id, 
            ie.nomeItem, 
            fe.quantidade, 
            ie.tipoMedida, 
            fe.data_operacao, 
            fe.motivo, 
            fe.documento_nf, 
            fe.documento_nf_tipo
        FROM 
            fluxoEstoque fe
        JOIN 
            itensEstoque ie ON fe.id_item = ie.id
        WHERE 
            fe.tipo_operacao = 'entrada'
        ORDER BY 
            fe.data_operacao DESC";

$result = $conexao->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $historicoEntradas[] = $row;
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Histórico de Compras</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }

        header {
            display: flex;
            text-align: center;
            padding: 5px;
            justify-content: space-between;
            background-color: #5f0608;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5em;
            color: #d19035;
            font-weight: bold;
            text-decoration: none;
        }
        .logo img { height: 120px; width: auto; }
        .logo:hover { color: #000; }

        nav { display: flex; gap: 25px; align-items: center; }
        nav a { text-decoration: none; color: #d19035; font-size: 0.95em; font-weight: 600; }
        nav a:hover { color: #ffffff; }

        .logout-btn {
            margin-left: 20px;
            background-color: transparent;
            color: #d19035;
            border: 2px solid #d19035;
            border-radius: 10px;
            padding: 6px 14px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .logout-btn:hover { background-color: #d19035; color: #530606; border-color: #d19035; }

        h1 { text-align: center; margin: 40px 0 20px; color: #5f0608; }

        main {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            background: #fdfaf6;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead tr {
            border-bottom: 2px solid #d19035;
        }

        th {
            background: #5f0608;
            padding: 14px;
            text-align: left;
            color: #d19035;
            font-weight: bold;
        }

        td {
            padding: 14px;
            border-top: 1px solid #ddd;
            text-align: left;
        }

        tr:nth-child(even) td {
            background-color: #f9f4ee;
        }

        tbody tr:hover td {
            background: #efe6da;
        }

        .no-records {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #777;
        }

        td a {
            color: #5f0608;
            font-weight: bold;
            text-decoration: none;
        }
        td a:hover { color: #d19035; }

        .material-symbols-outlined { vertical-align: middle; margin-right: 5px; }
    </style>
</head>
<body>
    <header>
        <a href="../indexFuncionario.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>
        <nav>
            <a href="paginaPrincipalFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="paginaRelatorios.php" class="active">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'"> Logout </button>
        </nav>
    </header>

    <main>
        <h1>Histórico de Compras (Entradas)</h1>

        <?php if (!empty($historicoEntradas)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Quantidade</th>
                        <th>Unidade</th>
                        <th>Data</th>
                        <th>Motivo</th>
                        <th>Nota Fiscal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historicoEntradas as $entrada): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entrada['id']); ?></td>
                            <td><?php echo htmlspecialchars($entrada['nomeItem']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($entrada['quantidade'], 2, ',', '.')); ?></td>
                            <td><?php echo htmlspecialchars($entrada['tipoMedida']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($entrada['data_operacao']))); ?></td>
                            <td><?php echo htmlspecialchars($entrada['motivo']); ?></td>
                            <td>
                                <?php if (!empty($entrada['documento_nf'])): ?>
                                    <a href="visualizarNotaFiscal.php?id=<?php echo $entrada['id']; ?>" target="_blank">Ver NF</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">Nenhum registro de entrada encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>