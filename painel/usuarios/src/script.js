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



const finalizaButtons = document.querySelectorAll('.atualiza-button');
const modal = document.getElementById('atualizaModal');
const closeModal = document.querySelector('.modal .close');
const finalizaSubmit = document.getElementById('atualizaSubmit');
let currentItemId;

// Captura o ID do item quando o botão "Editar" é clicado
finalizaButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Obtém o ID do item do atributo data-id
        currentItemId = button.getAttribute('data-id');
    });
});

// Fecha a modal ao clicar no botão de fechar
closeModal?.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Fecha a modal ao clicar fora dela
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Envia os dados via AJAX ao clicar no botão "Salvar"
finalizaSubmit.addEventListener('click', () => {
    const texto = document.getElementById('novoNome').value;

    fetch('atualizar_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(currentItemId) + '&texto=' + encodeURIComponent(texto)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        modal.style.display = 'none';
        window.location.reload();
    })
    .catch(error => console.error('Error:', error));
});