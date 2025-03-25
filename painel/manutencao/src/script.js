//BUSCAR ITENS

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const searchResults = document.getElementById('searchResults');
    const selectedItem = document.getElementById('selectedItem');
    const selectedItemId = document.getElementById('selectedItemId');

    searchButton.addEventListener('click', function() {
        const query = searchInput.value.toLowerCase();
        searchResults.innerHTML = ''; // Limpa os resultados anteriores

        if (query.length > 0) {
            fetch('buscar_itens.php?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    const uniqueItems = new Set(); // Conjunto para armazenar itens únicos

                    data.forEach(item => {
                        if (!uniqueItems.has(item.id_item)) {
                            uniqueItems.add(item.id_item); // Adiciona o item ao conjunto

                            // Fetch the family name using the item.id_familia
                            fetch('get_familia_nome.php?id_familia=' + item.id_familia)
                                .then(response => response.json())
                                .then(familiaData => {
                                    const familiaNome = familiaData.ds_familia;
                                    const resultItem = document.createElement('a');
                                    resultItem.href = '#';
                                    resultItem.className = 'list-group-item list-group-item-action';
                                    resultItem.textContent = item.cod_patrimonio + ' - ' + item.ds_item + ' (Família: ' + familiaNome + ')';
                                    resultItem.dataset.id = item.id_item;

                                    resultItem.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        // Marcar o item selecionado
                                        selectedItem.innerHTML = 'Item selecionado: ' + item.cod_patrimonio + ' - ' + item.ds_item + ' (Família: ' + familiaNome + ')';
                                        selectedItemId.value = item.id_item; // Atualiza o campo oculto com o id_item
                                        searchResults.innerHTML = ''; // Limpa os resultados
                                        searchInput.value = ''; // Limpa o campo de busca
                                    });

                                    searchResults.appendChild(resultItem);
                                })
                                .catch(error => console.error('Error fetching family name:', error));
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });
});


//ENVIAR MANUTENçÂO

document.addEventListener('DOMContentLoaded', () => {
    const finalizaButtons = document.querySelectorAll('.finaliza-button');
    const modal = document.getElementById('finalizaModal');
    const closeModal = document.querySelector('#finalizaModal .btn-close'); // Ajuste o seletor para o botão de fechar
    const finalizaSubmit = document.getElementById('finalizaSubmit');
    let currentItemId;

    // Ao clicar no botão "Retornar item"
    finalizaButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentItemId = button.id; // Define o ID do item selecionado
            modal.style.display = 'block'; // Exibe o modal
        });
    });

    // Fecha o modal ao clicar no botão "Cancelar" ou fora do modal
    if (closeModal) {
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Lógica do botão "Enviar" no modal
    finalizaSubmit.addEventListener('click', () => {
        const texto = document.getElementById('finalizaTexto').value.trim();
        const status = document.getElementById('statusSelect').value;
        const custo = document.getElementById('custo_manutencao').value;

        // Verifica se os campos estão preenchidos
        if (!currentItemId || !texto || !status) {
            alert('Preencha todos os campos obrigatórios.');
            return;
        }

        // Envia a requisição AJAX
        fetch('finaliza_manutencao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(currentItemId) + '&texto=' + encodeURIComponent(texto) + '&status=' + encodeURIComponent(status) + '&custo=' + encodeURIComponent(custo)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor.');
            }
            return response.text();
        })
        .then(data => {
            console.log(data); // Exibe a resposta do servidor no console
            modal.style.display = 'none'; // Fecha o modal
            window.location.reload(); // Recarrega a página
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao processar a solicitação. Por favor, tente novamente.');
        });
    });
});