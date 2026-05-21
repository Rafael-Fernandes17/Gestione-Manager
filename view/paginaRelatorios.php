<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
verificaAdm();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Central de Relatórios</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
* { margin: 0; padding: 0; }

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
    max-width: 800px;
    margin: 30px auto;
    background: #fdfaf6;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
}

.report-buttons { display: flex; flex-direction: column; gap: 15px; margin-top: 30px; }
.report-buttons a {
    display: block;
    padding: 15px 25px;
    background-color: #5f0608;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
.report-buttons a:hover { background-color: #d19035; color: #530606; transform: translateY(-2px); }
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
        <h1>Central de Relatórios</h1>
        <div class="report-buttons">
            <a href="relatorioHistoricoCompras.php">Relatório de Histórico de Compra</a>
            <a href="#">Relatório de Faturamento (Em Breve)</a>
            <a href="#">Relatório de Pratos mais pedidos (Em Breve)</a>
            <a href="#">Relatório de Desperdício (Em Breve)</a>
        </div>
    </main>
</body>
</html>
