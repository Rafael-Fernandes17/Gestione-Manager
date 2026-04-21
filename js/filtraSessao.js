async function verificarSessao() {
    try {
        const resp = await fetch('../php/verificaSessao.php', {
            headers: {
                'Accept': 'application/json' 
            }
        });
  
        const data = await resp.json();

        if (data.status === 'nok') {
            alert("Atenção: " + data.mensagem);
            window.location.href = "../html/login.html";
            return false; 
        } 
    } catch (erro) {
        console.error("Erro ao verificar sessão:", erro);
        return false;
    }
}