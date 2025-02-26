document.addEventListener("DOMContentLoaded", function () {
    const filtroPrincipal = document.getElementById("filtro_principal");
    const divNatureza = document.getElementById("filtro_natureza");
    const divFamilia = document.getElementById("filtro_familia");

    // Função para alternar a visibilidade das divs
    filtroPrincipal.addEventListener("change", function () {
        const valorSelecionado = filtroPrincipal.value;

        // Oculta ambas as divs inicialmente
        divNatureza.style.display = "none";
        divFamilia.style.display = "none";

        // Exibe a div correspondente à opção selecionada
        if (valorSelecionado === "natureza") {
            divNatureza.style.display = "inline-block";
        } else if (valorSelecionado === "familia") {
            divFamilia.style.display = "inline-block";
        }
    });
});