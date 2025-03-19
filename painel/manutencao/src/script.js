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