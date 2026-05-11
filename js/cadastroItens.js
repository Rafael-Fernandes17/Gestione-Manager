async function cadastrar() {
    const formData = new FormData();
    formData.append('nome', document.getElementById('nome').value);
    formData.append('categoria', document.getElementById('categoria').value);
    formData.append('unidade', document.getElementById('unidade').value);
    formData.append('quantidade', document.getElementById('quantidade').value);

    try {
        const response = await fetch('../php/novoItens.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'ok') {
            alert(result.mensagem);
            window.location.href = 'readItens.php'; // Redireciona após sucesso
        } else {
            alert('Erro: ' + result.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
    }
}