<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Manager - Cadastro</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/cadastrarFuncionario.css">
    <script src="../js/filtraSessaoAdm.js"></script>
</head>

<body>

    <header>
        <a href="../php/login.html" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>

        <nav>
            <a href="../php/home.php">HOME</a>
            <a href="aindaNao.html">DASHBOARD</a>
            <a href="aindaNao.html">CAIXA</a>
            <a href="../php/estoque.php">ESTOQUE</a>
            <a href="../php/readProdutoCardapio.php">PRODUTOS</a>
            <a href="aindaNao.html">FINANCEIRO</a>
            <a href="aindaNao.html">RELATÓRIOS</a>
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
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="caixa-organizadora">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="caixa-organizadora" id="caixa-adm">
                <input type="checkbox" name="eAdm" placeholder="eAdm" id="eAdm"> <p>O funcionário a ser cadastrado possuirá 
                    permissões de administrador.</p>
            </div>
            
            <div class="caixa-organizadora">
                <button type="submit">CADASTRAR</button>
            </div>
        </form>
    </main>

    </div>
 <script src="../js/cadastrarFuncionario.js"></script>
</body>
</html>