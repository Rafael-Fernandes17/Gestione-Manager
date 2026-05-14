const botao = document.getElementById("botao");

botao.addEventListener('click', function(e) {  
    e.preventDefault(); 
    cadastrarFuncionario();
});

async function cadastrarFuncionario() {
    const fd = new FormData(); 

    fd.append("nome", document.getElementById("nome").value);
    fd.append("email", document.getElementById("email").value);
    fd.append("senha", document.getElementById("senha").value);

    const eAdm = document.getElementById("eAdm");

    console.log(eAdm.checked);

    if (eAdm.checked) {
        fd.append("eAdm", "1");
    }

    try {
        const perguntaAoPHP = await fetch("../php/cadastrarFuncionario.php", {
            method: "POST",
            body: fd,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    

        const resposta = await perguntaAoPHP.json();

        // 3. Uso do Optional Chaining (?.) para evitar que o JS quebre
        const msg = resposta.mensagem ? resposta.mensagem.toLowerCase() : "";
        const status = resposta.status ? resposta.status.toLowerCase() : "";

        if(status === 'nok'){
            if (msg === "email repetido") {
                alert("Este e-mail já está cadastrado!");
            } else if (msg === "preencha todos os campos") {
                alert("Preencha todos os campos!");
            } else if (msg === "email invalido") {
                alert("E-mail inválido!");
            } 
        } else if (status === 'ok') {
            alert("Funcionário cadastrado com sucesso!");
            window.location.reload();
        }
    } catch (erro) {
                console.error("Erro ao ler o JSON do PHP:", erro);
            }
}