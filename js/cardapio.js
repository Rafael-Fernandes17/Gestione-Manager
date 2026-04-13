const botoes = document.querySelectorAll("nav button");
const cards = document.querySelectorAll(".card");

botoes.forEach(botao => {
    botao.addEventListener("click", () => {

        // remove active
        botoes.forEach(b => b.classList.remove("active"));
        botao.classList.add("active");

        const categoria = botao.getAttribute("data-categoria");

        cards.forEach(card => {
            const catCard = card.getAttribute("data-categoria");

            if (catCard === categoria) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });

    });
});


document.querySelector(".active").click();