document.addEventListener("DOMContentLoaded", () => {
    
    const formProduto = document.querySelector("form");

    if (formProduto) {
        formProduto.addEventListener("submit", async function(event) {
            event.preventDefault(); 

            const formData = new FormData(this);
            const urlPHP = this.getAttribute("action");

            try {
                const response = await fetch(urlPHP, {
                    method: "POST",
                    body: formData,
                    headers: { 'Accept': 'application/json' }
                });

                const data = await response.json();

                if (data.status === "nok") {
                    
                    switch (data.mensagem) {
                        case 'preencha todos os campos':
                            alert("⚠️ Por favor, preencha todos os dados obrigatórios do produto antes de salvar.");
                            break;
                            
                        case 'erro ao enviar imagem':
                        case 'erro ao ler imagem':
                            alert("🖼️ Houve um problema com a foto selecionada. Tente enviar uma imagem diferente ou em outro formato.");
                            break;
                            
                        case 'erro ao cadastrar produto':
                            alert("❌ Não foi possível salvar o produto no momento. Tente novamente.");
                            break;
                            
                        default:
                            console.error("Erro interno do servidor:", data.mensagem);
                            alert("🛠️ Ocorreu um erro interno no servidor. Contate o suporte.");
                            break;
                    }
                    return;
                }

                if (data.status === "ok") {
                    alert("✅ " + data.mensagem);
                    
                    window.location.href = '../php/readProdutoCardapio.php';
                    
                }

            } catch (error) {
                console.error("Erro na comunicação Fetch:", error);
                alert("🌐 Falha de comunicação. Verifique sua conexão com a internet.");
            }
        });
    }
});