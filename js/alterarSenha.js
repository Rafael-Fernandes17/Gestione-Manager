document.getElementById("formAlterarSenha").addEventListener("submit", async (e) => {
    e.preventDefault();

    const novaSenha = document.getElementById("nova_senha").value;
    const confirmarSenha = document.getElementById("confirmar_senha").value;

    if (novaSenha !== confirmarSenha) {
        alert("As senhas não coincidem!");
        return;
    }

    const dadosFormulario = new FormData();
    dadosFormulario.append("nova_senha", novaSenha);
    dadosFormulario.append("confirmar_senha", confirmarSenha);

    try {
        const respostaPHP = await fetch("../php/alterarSenha.php", {
            method: "POST",
            body: dadosFormulario,
            headers: { "Accept": "application/json" }
        });
        const resposta = await respostaPHP.json();

        if (resposta.status === "ok") {
            alert(resposta.message);
            window.location.href = "../view/paginaPrincipalFuncionario.php"; // Redirecionar para a página principal após a alteração
        } else {
            alert(resposta.message);
        }
    } catch (error) {
        console.error("Erro ao alterar a senha:", error);
        alert("Ocorreu um erro ao tentar alterar a senha.");
    }
});
