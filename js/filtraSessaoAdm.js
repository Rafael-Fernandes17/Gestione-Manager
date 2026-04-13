
(async function verificarAcessoPagina() {
    try {
        const resposta = await fetch('../php/verificaAdm.php', {
            headers: { 'Accept': 'application/json' }
        });
        const dados = await resposta.json();

        if (dados.eAdm !== 'ok') {
            alert("Acesso Bloqueado: Apenas Administradores!");
            window.location.href = "../indexFuncionario.php";
        }
    } catch (erro) {
        console.error("Erro na verificação de entrada:", erro);
    }
})();