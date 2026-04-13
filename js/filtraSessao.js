// Este código "escuta" TODOS os envios de formulário da sua página
document.addEventListener('submit', async function(event) {
    
    // 1. A MÁGICA GLOBAL: Segura a página de TODOS os formulários!
    event.preventDefault(); 

    // 2. Descobre qual formulário foi clicado
    const formClicado = event.target;
    
    // 3. Pega o caminho do PHP direto do HTML (ex: action="../php/novoItens.php")
    const urlPHP = formClicado.getAttribute('action');
    
    // Se o formulário não tiver o 'action', ele ignora e não faz o fetch
    if (!urlPHP) return; 

    // 4. Pega TODOS os dados dos inputs sozinhos (não precisa de document.getElementById!)
    // IMPORTANTE: Seus <input> precisam ter o atributo 'name' (ex: name="nome")
    const fd = new FormData(formClicado); 

    try {
        // 5. Faz a comunicação com o PHP
        const resp = await fetch(urlPHP, {
            method: "POST",
            body: fd,
            headers: { "Accept": "application/json" }
        });

        const data = await resp.json();

        // 6. O SEU FILTRO DE SESSÃO GLOBAL AQUI:
        if (data.status === 'nok' || (data.status === 'erro' && data.mensagem === 'sessao_invalida')) {
            alert("Sua sessão expirou. Faça login novamente.");
            window.location.href = "../html/login.html";
            return; // Para tudo!
        }

        // 7. Se deu tudo certo
        alert("Salvo com sucesso!");
        
        // Dica extra: você pode colocar um atributo no HTML para dizer para onde ir depois
        const urlDestino = formClicado.getAttribute('data-redirect');
        if (urlDestino) {
            window.location.href = urlDestino;
        }

    } catch (erro) {
        console.error("Erro na comunicação:", erro);
        alert("Ocorreu um erro no servidor.");
    }
});