async function cadastrar() {
    const nome = document.getElementById('nome').value;
    const categoria = document.getElementById('categoria').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const valor = document.getElementById('valor').value;
    const unidade = document.getElementById('unidade').value;
    const estoqueMinimo = document.getElementById('estoqueMinimo').value;


    if (!nome || !categoria) return alert("Preencha o nome e a categoria!");

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("categoria", categoria);
    fd.append("quantidade", quantidade);
    fd.append("unidade", unidade);

    
    const resp = await fetch("../php/cadastrarItemEstoque.php", {
    method: "POST",
    body: fd
});

const data = await resp.json(); 

    if (data.status === 'ok') {
        alert(data.mensagem); 
        window.location.href = "../view/listaItemEstoque.php"; 
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('categoria', categoria);
    formData.append('fornecedor', fornecedor);
    formData.append('valor', valor);
    formData.append('unidade', unidade);
    formData.append('estoqueMinimo', estoqueMinimo);

    try {
        const response = await fetch('../php/cadastrarItemEstoque.php', { 
    method: 'POST',
    body: formData
});
        const data = await response.json();

        alert(data.mensagem);
        if (data.status === 'ok') {
            window.location.href = '../view/listaItemEstoque.php';
        }
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao conectar com o servidor.");
    }
}