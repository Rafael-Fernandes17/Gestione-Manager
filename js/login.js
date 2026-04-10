function exibirSenha() {
    const input = document.getElementById('senha');
    const icone = document.getElementById('imagemOlhinho');

    // O "comportamento" de alternar estados
    if (input.type === 'password') {
        input.type = 'text';
        icone.src = '../img/olhinhoAberto2.png'; // Feedback de estado ativo
    } else {
        input.type = 'password';
        icone.src = '../img/olhinhoFechado.png';  // Feedback de estado inativo
    }
}

// js/cliente_login.js
document.getElementById('botaoEnviar').addEventListener('click', () => {
    login();
});

async function login() {
    const dadosFormulario = new FormData();
    dadosFormulario.append('email', document.getElementById('email').value);
    dadosFormulario.append('senha', document.getElementById('senha').value);

    const retorno = await fetch('../php/login.php', {
        method: 'POST',
        body: dadosFormulario
    });
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        window.location.href = '../index.html';
    } else if(resposta.status == 'nok') {
        if(resposta.mensagem.trim().Uppercase() == 'senha invalida') {
            alert('Senha inválida');
            return;
        }
        alert('Credenciais inválidas');
    }
}