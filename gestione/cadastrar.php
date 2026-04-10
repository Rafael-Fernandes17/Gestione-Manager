<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestione Manager - Cadastro</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
}

/* FUNDO */
body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    background: radial-gradient(circle at center,
        #b30000 0%,
        #990000 40%,
        #7a0000 75%,
        #660000 100%);
}

/* CONTAINER */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
}

/* LOGO MAIOR */
.logo img {
    width: 500px;
    max-width: 95%;
}

/* FORMULÁRIO MENOR E CENTRALIZADO */
.form-container {
    width: 390px; /* menor */
    max-width: 90%;
    background: #efe6db;
    border-radius: 30px;
    padding: 30px;
    box-shadow:
        0 15px 30px rgba(0,0,0,0.3),
        inset 0 1px 0 rgba(255,255,255,0.5);
}

/* INPUTS */
.input-group {
    position: relative;
    margin-bottom: 16px;
}

.input-group input {
    width: 100%;
    height: 55px;
    border-radius: 14px;
    border: none;
    background: #fffefedf;
    padding: 0 20px 0 50px;
    font-size: 15px;
    outline: none;
    margin-top: 10px;
}

/* ÍCONES */
.input-group i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #c89d42;
    font-size: 16px;
}

/* BOTÃO */
button {
    width: 100%;
    height: 55px;
    border: none;
    border-radius: 12px;

    background: linear-gradient(to bottom, #d8a246, #b8791c);
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.3),
        0 6px 12px rgba(0,0,0,0.2);

    transition: 0.2s;
}

button:hover {
    transform: translateY(-2px);
}

/* RESPONSIVO */
@media (max-width: 500px) {
    .logo img {
        width: 95%;
    }

    .form-container {
        width: 90%;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="logo">
        <img src="logo.png" alt="Gestione Manager">
    </div>

    <div class="form-container">
        <form action="salvar.php" method="POST">

            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="nome" placeholder="Nome" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <button type="submit">CADASTRAR</button>

        </form>
    </div>

</div>

</body>
</html>