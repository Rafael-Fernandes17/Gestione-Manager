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
            headers: { "Accept": "application/json" }
        });

        const data = await resp.json();

        if (data.status === 'nok' || (data.status === 'erro' && data.mensagem === 'sessao_invalida')) {
            alert("Sua sessão expirou. Faça login novamente.");
            window.location.href = "../html/login.html";
            return;
        }

        alert("Salvo com sucesso!");
        
        const urlDestino = formClicado.getAttribute('data-redirect');
        if (urlDestino) {
            window.location.href = urlDestino;
        }

    } catch (erro) {
        console.error("Erro na comunicação:", erro);
        alert("Ocorreu um erro no servidor.");
    }
});