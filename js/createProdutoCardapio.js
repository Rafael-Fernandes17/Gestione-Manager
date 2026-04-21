document.addEventListener("DOMContentLoaded", () => {
    
    const botao = document.getElementById("botao");

    if (botao) {
        botao.addEventListener("click", async function(event) {

            event.preventDefault(); 
            const sessaoEstaAtiva = await verificarSessao();

            if (!sessaoEstaAtiva) {
                return; 
            }

            // 1. Captura os valores usando os IDs exatos do seu HTML
            const nome = document.getElementById("nomeProdutoCardapio").value;
            const descricao = document.getElementById("descricao").value;
            const categoria = document.getElementById("categoria").value;
            const tempoPreparo = document.getElementById("tempoPreparo").value;
            const preco = document.getElementById("preco").value;
            const quantidade = document.getElementById("quantidade").value;
            const tipoMedida = document.getElementById("tipoMedida").value;
            const statusProdutos = document.getElementById("statusProdutos").value;

            const inputFoto = document.getElementById("imagem"); 
            const arquivoFoto = inputFoto ? inputFoto.files[0] : null;

            const formData = new FormData();
            formData.append("nomeProdutoCardapio", nome);
            formData.append("descricao", descricao);
            formData.append("categoria", categoria);
            formData.append("tempoPreparo", tempoPreparo);
            formData.append("preco", preco);
            formData.append("quantidade", quantidade);
            formData.append("tipoMedida", tipoMedida);
            formData.append("statusProdutos", statusProdutos);
            formData.append("imagem", arquivoFoto); 

            const urlPHP = "../php/createProdutoCardapio.php"; 

            try {
                // 4. Faz a requisição Fetch
                const response = await fetch(urlPHP, {
                    method: "POST",
                    body: formData,
                    headers: { 
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // ADICIONE ESTA LINHA
                    }
                });

                const data = await response.json();

                // 5. Tratamento das respostas
                if (data.status === "nok") {
                    switch (data.mensagem) {
                        case 'preencha todos os campos':
                            alert("⚠️ Por favor, preencha todos os dados obrigatórios.");
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
                alert("🌐 Falha de comunicação. Verifique sua conexão com a internet ou contate o suporte.");
            }
        });
    } else {
        console.error("Botão de submit não encontrado. Verifique se o ID 'submit-btn' está no seu <button> HTML.");
    }
});