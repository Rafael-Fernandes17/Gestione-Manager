const form = document.getElementById('form');
    
form.addEventListener('submit', async function(e) {
    e.preventDefault(); 

    // 3. O JS pega os dados que estão nos inputs do HTML
    const dadosDoForm = new FormData(this); 

    // 4. O JS envia esses dados para o PHP e ESPERA a resposta
    try {
        const perguntaAoPHP = await fetch("../php/cadastrarFuncionario.php", {
            method: "POST",
            body: dadosDoForm,
            headers: {
                // ESSAS DUAS LINHAS SÃO A CHAVE:
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    

        const resposta = await perguntaAoPHP.json();

        // 1. Tratamento de Sessão (Prioridade máxima)
        if (resposta.mensagem === 'sessao_invalida' || resposta.status === 'sessao_invalida') {
            alert("Sua sessão expirou!");
            window.location.href = "../html/login.html";
            return; // Para o código aqui
        }


        // 3. Uso do Optional Chaining (?.) para evitar que o JS quebre
        const msg = resposta.mensagem ? resposta.mensagem.toLowerCase() : "";
        const status = resposta.status ? resposta.status.toLowerCase() : "";

        if (msg === "email repetido") {
            alert("Este e-mail já está cadastrado!");
        } else if (msg === "preencha todos os campos") {
            alert("Preencha todos os campos!");
        } else if (msg === "email invalido") {
            alert("E-mail inválido!");
        } else if (status === 'nok') {
            alert("Erro ao cadastrar, tente novamente.");
        } else if (status === 'ok') {
            alert("Funcionário cadastrado com sucesso!");
            window.location.reload();
        }
            } catch (erro) {
                console.error("Erro ao ler o JSON do PHP:", erro);
            }
});