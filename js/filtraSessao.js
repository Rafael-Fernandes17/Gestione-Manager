// Este código "escuta" TODOS os envios de formulário da sua página
document.addEventListener('submit', async function(event) {
    
    event.preventDefault(); 

    const formClicado = event.target;
    const urlPHP = formClicado.getAttribute('action');

    if (!urlPHP) return; 

    const fd = new FormData(formClicado); 

    try {
        const resp = await fetch(urlPHP, {
            method: "POST",
            body: fd,
            headers: { 'Accept': 'application/json'}
        });

        // Transforma a resposta do PHP em um objeto JavaScript
        const data = await resp.json();

        // 1. Se o PHP avisar que deu ERRO (campos vazios, erro no banco, etc)
        if (data.status === 'nok') {
            // Mostra a mensagem exata que o PHP mandou
            alert("Atenção: " + data.mensagem); 
            
            // Mantém a sua lógica de sessão expirada caso precise no futuro
            if (data.mensagem === 'sessao_invalida') {
                window.location.href = "../html/login.html";
            }
            return; // Para a execução aqui, não redireciona
        }

        // 2. Se o PHP avisar que deu SUCESSO ('status' === 'ok')
        if (data.status === 'ok') {
            alert(data.mensagem || "Salvo com sucesso!");
            
            const urlDestino = formClicado.getAttribute('data-redirect');
            if (urlDestino) {
                window.location.href = urlDestino;
            }
        }

    } catch (erro) {
        // 3. Se der erro de rede ou o PHP cuspir HTML em vez de JSON
        console.error("Erro na comunicação:", erro);
        alert("Ocorreu um erro no servidor. Verifique o console.");
    }
});