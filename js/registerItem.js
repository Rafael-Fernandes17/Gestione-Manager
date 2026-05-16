async function cadastrar() {
    const nome = document.getElementById('nome').value;
    const categoria = document.getElementById('categoria').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const valor = document.getElementById('valor').value;
    const unidade = document.getElementById('unidade').value;
    const estoqueMinimo = document.getElementById('estoqueMinimo').value;

    // Critério de Aceite 2
    if (parseFloat(estoqueMinimo) <= 0) {
        alert("Erro: O estoque mínimo precisa ser maior que 0.");
        return;
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('categoria', categoria);
    formData.append('fornecedor', fornecedor);
    formData.append('valor', valor);
    formData.append('unidade', unidade);
    formData.append('estoqueMinimo', estoqueMinimo);

    try {
        const response = await fetch('../php/createItem.php', { 
    method: 'POST',
    body: formData
});
        const data = await response.json();

        alert(data.mensagem);
        if (data.status === 'ok') {
            window.location.href = '../php/readItem.php';
        }
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao conectar com o servidor.");
    }
}