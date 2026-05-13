const botao = document.getElementById("botao");

botao.addEventListener('click', function(e) {  
    e.preventDefault(); 
    cadastrarFuncionario();
});

async function cadastrarFuncionario() {
    const fd = new FormData(); 

    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let senha = document.getElementById("senha").value;
    let eAdm = document.getElementById("eAdm").value;

    fd.append("nome", nome);
    fd.append("email", email);
    fd.append("senha", senha);
    fd.append("eAdm", eAdm);

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
            } else if (msg === "nao e adm") {
                alert("Permissao negada");
            }
        } else if (status === 'ok') {
            alert("Funcionário cadastrado com sucesso!");
            window.location.reload();
        }
    } catch (erro) {
                console.error("Erro ao ler o JSON do PHP:", erro);
            }
}