async function cadastrar() {
    const nome = document.getElementById('nome').value;
    const categoria = document.getElementById('categoria').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const valor = document.getElementById('valor').value;
    const unidade = document.getElementById('unidade').value;
    const estoqueMinimo = document.getElementById('estoqueMinimo').value;

<<<<<<< HEAD:js/cadastroItens.js
    // Critério de Aceite 2
    if (parseFloat(estoqueMinimo) <= 0) {
        alert("Erro: O estoque mínimo precisa ser maior que 0.");
        return;
=======
    let nome = document.getElementById("nome").value;
    let categoria = document.getElementById("categoria").value;
    let quantidade = document.getElementById("quantidade").value;
    let unidade = document.getElementById("unidade").value;

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
>>>>>>> a9adef64fe42e02cbc5a8b525479c22871fe412b:js/cadastrarItemEstoque.js
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('categoria', categoria);
    formData.append('fornecedor', fornecedor);
    formData.append('valor', valor);
    formData.append('unidade', unidade);
    formData.append('estoqueMinimo', estoqueMinimo);

    try {
        const response = await fetch('../php/novoItens.php', { 
    method: 'POST',
    body: formData
});
        const data = await response.json();

        alert(data.mensagem);
        if (data.status === 'ok') {
            window.location.href = '../php/readItens.php';
        }
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao conectar com o servidor.");
    }
}