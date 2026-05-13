async function cadastrar() {
    const formData = new FormData();
    formData.append('nome', document.getElementById('nome').value);
    formData.append('categoria', document.getElementById('categoria').value);
    formData.append('fornecedor', document.getElementById('fornecedor').value);
    formData.append('valor', document.getElementById('valor').value);
    formData.append('unidade', document.getElementById('unidade').value);
    formData.append('estoqueMinimo', document.getElementById('estoqueMinimo').value);

    // Validação básica do valor
    if (document.getElementById('valor').value <= 0) {
        alert("O valor do item deve ser maior que zero.");
        return;
    }

    try {
        const response = await fetch('../php/novoItens.php', { method: 'POST', body: formData });
        const data = await response.json();
        alert(data.mensagem);
        if (data.status === 'ok') window.location.href = 'readItens.php';
    } catch (e) {
        alert("Erro na conexão.");
    }
}