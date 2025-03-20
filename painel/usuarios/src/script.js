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

document.addEventListener("DOMContentLoaded", function () {
    const finalizaButtons = document.querySelectorAll('.atualiza-button');
    const modal = new bootstrap.Modal(document.getElementById('atualizaModal')); // Usa o Modal do Bootstrap
    const closeModal = document.querySelector('#atualizaModal .btn-close'); // Fecha a modal pelo botão de fechar
    const finalizaSubmit = document.getElementById('atualizaSubmit');
    let currentItemId;

    // Captura o ID do item e preenche os campos da modal quando o botão "Editar" é clicado
    finalizaButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Obtém o ID do funcionário do atributo data-id
            currentItemId = button.getAttribute('data-id');

            // Encontra o funcionário correspondente na tabela
            const row = button.closest('tr'); // Linha da tabela onde o botão foi clicado
            const nome = row.querySelector('td:nth-child(2)').textContent; // Nome (2ª coluna)
            const contato = row.querySelector('td:nth-child(3)').textContent; // Contato (3ª coluna)
            const nivel = row.querySelector('td:nth-child(4)').textContent; // Nível (4ª coluna)

            // Preenche os campos da modal com os valores do funcionário
            document.getElementById('novoNome').value = nome;
            document.getElementById('novoContato').value = contato;

            // Define o valor selecionado no dropdown de nível de permissão
            const nivelSelect = document.querySelector('#atualizaModal select');
            nivelSelect.value = nivel.trim(); // Remove espaços em branco e define o valor

            // Exibe a modal
            modal.show();
        });
    });

    // Fecha a modal ao clicar no botão de fechar
    closeModal?.addEventListener('click', () => {
        modal.hide();
    });

    // Fecha a modal ao clicar fora dela
    window.onclick = function (event) {
        if (event.target === document.getElementById('atualizaModal')) {
            modal.hide();
        }
    };

    // Envia os dados via AJAX ao clicar no botão "Salvar"
    finalizaSubmit.addEventListener('click', () => {
        const novoNome = document.getElementById('novoNome').value;
        const novoContato = document.getElementById('novoContato').value;
        const novoNivel = document.querySelector('#atualizaModal select').value;

        fetch('atualizar_usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id_usuario=${encodeURIComponent(currentItemId)}&nm_usuario=${encodeURIComponent(novoNome)}&nr_contato=${encodeURIComponent(novoContato)}&nv_permissao=${encodeURIComponent(novoNivel)}`
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                modal.hide(); // Fecha a modal após salvar
                window.location.reload(); // Recarrega a página para refletir as mudanças
            })
            .catch(error => console.error('Error:', error));
    });
});