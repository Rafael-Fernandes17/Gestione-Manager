<?php
    require_once '../php/verificaPermissao.php'; 
    verificaAdm();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Manager - Cadastro</title>
    <link rel="stylesheet" href="../css/resetando.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/cadastrarFuncionario.css">
</head>

<body>

    <header>
        <a href="../php/logout.php" class="logo">
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
        <form id="form">
            <div class="caixa-organizadora">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="nome" placeholder="Nome" id="nome" required>
            </div>

            <div class="caixa-organizadora">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="E-mail" id="email" required>
            </div>

            <div class="caixa-organizadora">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" id="senha" required>
            </div>

            <div class="caixa-organizadora" id="caixa-adm">
                <input type="checkbox" name="eAdm" placeholder="eAdm" id="eAdm" value = "1"> <p>O funcionário a ser cadastrado possuirá 
                    permissões de administrador.</p>
            </div>
            
            <div class="caixa-organizadora">
                <button type="submit" id="botao">CADASTRAR</button>
            </div>
        </form>
    </main>

    </div>
 <script src="../js/cadastrarFuncionario.js"></script>
</body>
</html>
