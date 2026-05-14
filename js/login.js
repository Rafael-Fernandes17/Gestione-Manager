function exibirSenha() {
    const input = document.getElementById('senha');
    const icone = document.getElementById('imagemOlhinho');

    if (input.type === 'password') {
        input.type = 'text';
        icone.src = '../img/olhinhoAberto2.png';
    } else {
        input.type = 'password';
        icone.src = '../img/olhinhoFechado.png';
    }
}

document.getElementById('botaoEnviar').addEventListener('click', (e) => {
    login(e);
});

async function login(e) {
    e.preventDefault();

    const dadosFormulario = new FormData();
    dadosFormulario.append('email', document.getElementById('email').value);
    dadosFormulario.append('senha', document.getElementById('senha').value);

    const perguntaAoPHP = await fetch('../php/login.php', {
        method: 'POST',
        body: dadosFormulario,
        headers: { 'Accept': 'application/json' }
    });
    const resposta = await perguntaAoPHP.json();

    if (resposta.status == 'ok') {
        window.location.href = '../indexFuncionario.php';
    } else if (resposta.status == 'primeiro_acesso') {
        window.location.href = '../html/alterar_senha.html';
    } else if (resposta.status == 'nok') {
        alert("Credenciais Inválidas!");
        window.location.reload();
    }
}