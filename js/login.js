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
        body: dadosFormulario
    });
    const resposta = await perguntaAoPHP.json();

    if(resposta.status == 'ok') {
        if(resposta.data.eAdm == true || resposta.data.eAdm == 1) {
            window.location.href = '../index.html';
        } else if(resposta.data.eAdm == false || resposta.data.eAdm == 0) {
            window.location.href = '../indexFuncionario.html';
        }
    } else if(resposta.status == 'nok') {
        alert("Credenciais Inválidas!");
    }
}