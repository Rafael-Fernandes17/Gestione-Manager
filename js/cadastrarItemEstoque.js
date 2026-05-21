// Executa automaticamente ao carregar a página para checar se veio um ID na URL (Modo Alterar)
document.addEventListener("DOMContentLoaded", async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        document.getElementById('tituloPagina').innerText = "Alterar Insumo";
        try {
            const response = await fetch(`../php/obterItemEstoque.php?id=${id}`);
            if (response.ok) {
                const item = await response.json();
                
                document.getElementById('idItem').value = item.id;
                document.getElementById('nome').value = item.nomeItem;
                document.getElementById('categoria').value = item.categoria || 'Ingredientes';
                document.getElementById('fornecedor').value = item.fornecedor;
                document.getElementById('valor').value = item.valorItem;
                document.getElementById('estoqueMinimo').value = item.estoqueMinimo;
                
                const selectUnidade = document.getElementById('unidade');
                if(item.tipoMedida) {
                    selectUnidade.value = item.tipoMedida.toUpperCase();
                }
            }
        } catch (error) {
            console.error("Erro ao carregar dados do insumo:", error);
        }
    }
});

async function cadastrar() {
    let idItem = document.getElementById('idItem') ? document.getElementById('idItem').value : '';
    
    const nome = document.getElementById('nome').value.trim();
    const categoria = document.getElementById('categoria').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const valor = document.getElementById('valor').value;
    const unidade = document.getElementById('unidade').value; 
    const estoqueMinimo = document.getElementById('estoqueMinimo').value;

    // 1. Validação de campos vazios primeiro
    if (!nome || estoqueMinimo === "" || valor === "") {
        alert("Erro: Por favor, preencha todos os campos obrigatórios (Nome, Valor e Estoque Mínimo).");
        return;
    }

    // Convertendo para números para fazer as checagens matemáticas precisas
    const numValor = parseFloat(valor);
    const numEstoqueMinimo = parseFloat(estoqueMinimo);

    // 2. Validação individual do Valor Unitário (Impede 0 e Negativos)
    if (numValor <= 0) {
        alert("Erro: O valor precisa ser maior que zero.");
        return;
    }

    // 3. Validação individual do Estoque Mínimo (Impede 0 e Negativos)
    if (numEstoqueMinimo <= 0) {
        alert("Erro: O estoque mínimo precisa ser maior que zero.");
        return;
    }

    // Se passar nas travas, monta e envia os dados
    const formData = new FormData();
    formData.append('idItem', idItem); 
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
            window.location.href = 'listaItemEstoque.php';
        }
    } catch (error) {
        alert("Erro ao processar requisição no servidor.");
        console.error(error);
    }
}