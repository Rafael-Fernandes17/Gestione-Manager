async function cadastrar() {
    // Captura o ID (se tiver valor é alteração, se estiver vazio é cadastro novo)
    let idItem = document.getElementById('idItem') ? document.getElementById('idItem').value : '';
    
    const nome = document.getElementById('nome').value;
    const categoria = document.getElementById('categoria').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const valor = document.getElementById('valor').value;
    const unidade = document.getElementById('unidade').value;
    const estoqueMinimo = document.getElementById('estoqueMinimo').value;

    // Validações obrigatórias
    if (!nome || !estoqueMinimo) {
        alert("Erro: Preencha os campos obrigatórios (Nome e Estoque Mínimo).");
        return;
    }

    if (parseFloat(estoqueMinimo) <= 0) {
        alert("Erro: O estoque mínimo precisa ser maior que 0.");
        return;
    }

    const formData = new FormData();
    formData.append('idItem', idItem); 
    formData.append('nome', nome);
    formData.append('categoria', categoria);
    formData.append('fornecedor', fornecedor);
    formData.append('valor', valor);
    formData.append('unidade', unidade);
    formData.append('estoqueMinimo', estoqueMinimo);

    try {
        // Envia com a terminação .php explícita para não gerar erro de rota
        const response = await fetch('../php/cadastrarItemEstoque.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        alert(data.mensagem);
        
        if (data.status === 'ok') {
            // Redireciona de volta para a sua tabela moderna e alinhada
            window.location.href = 'listaItemEstoque.php';
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
        alert("Erro ao conectar com o servidor. Verifique o console.");
    }
}