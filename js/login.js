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