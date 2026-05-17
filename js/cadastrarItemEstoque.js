async function cadastrar() {

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
    }
}   