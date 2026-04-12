const form = document.getElementById('form');
    
form.addEventListener('submit', async function(e) {
    e.preventDefault(); 

    // 3. O JS pega os dados que estão nos inputs do HTML
    const dadosDoForm = new FormData(this); 

    // 4. O JS envia esses dados para o PHP e ESPERA a resposta
    try {
        const perguntaAoPHP = await fetch("../php/cadastrarFuncionario.php", {
            method: "POST",
            body: dadosDoForm // Aqui os dados do HTML estão indo para o PHP
        });

        // 5. O PHP responde, e o JS lê essa resposta
        const resposta = await perguntaAoPHP.json();

        // 6. O JS age conforme o que o PHP disse
        if (resposta.mensagem.toLowerCase() == "email repetido") {
            alert("Este e-mail já está cadastrado!");
        } else if (resposta.mensagem.toLowerCase() === "Preencha todos os campos") {
            alert("Preencha todos os campos!");
        } else if (resposta.mensagem.toLowerCase() === "email invalido") {
            alert("E-mail inválido!");
        }  else if(resposta.status.toLowerCase() == 'nok') {
            alert("Erro ao cadastra, tente novamente.");
        } else if(resposta.status.toLowerCase() == 'ok') {
            alert("Funcionário cadastrado com sucesso!");
            window.location.reload();
        }
    } catch (erro) {
        console.error("Erro ao ler o JSON do PHP:", erro);
    }
});