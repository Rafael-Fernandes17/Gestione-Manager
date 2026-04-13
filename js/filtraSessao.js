async function filtrarSessao() {
    try {
        // Verifique se o caminho '../php/verificaSessao.php' está correto 
        // em relação ao arquivo HTML que chama este JS!
        const perguntaAoPHP = await fetch('../php/verificaSessao.php', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Isso evita o redirecionamento 302 automático
            }
        });

        const respostaPHP = await perguntaAoPHP.json();

        if (respostaPHP.status === 'nok') {
            alert("Sessão inválida ou expirada!");
            window.location.href = "../html/login.html";
        }
    } catch (error) {
        // Se cair aqui com "Unexpected token <", o PHP ainda enviou HTML
        console.error("Erro na verificação:", error);
    }
}

filtrarSessao();