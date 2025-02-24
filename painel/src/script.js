document.addEventListener('DOMContentLoaded', () => {
    const finalizaSubmit = document.getElementById('finalizaSubmit');
    finalizaSubmit.addEventListener('click', () => {
        const chaveSelect = document.getElementById('chaveSelect').value;
        const busca = document.getElementById('busca').value;
        fetch('pesquisa_itens.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'chave=' + encodeURIComponent(chaveSelect) + '&busca=' + encodeURIComponent(busca)
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('produtos');
            tableBody.innerHTML = ''; // Limpar tabela antes de preencher
            data.forEach(item => {
                const row = document.createElement('tr');
                if (item.nr_disponibilidade === 0) {
                    row.innerHTML = `
                        <td>${item.cod_patrimonio}</td>
                        <td>${item.ds_item}</td>
                        <td>${item.familia}</td>
                        <td>${item.movimentacao}</td>
                        <td>${item.usuario}</td>
                        <td><button class="devolver-btn" data-id="${item.id_item}">Devolver Item</button></td>  
                    `;
                } else {
                    row.innerHTML = `
                        <td>${item.cod_patrimonio}</td>
                        <td>${item.ds_item}</td>
                        <td>${item.familia}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>Disponivel</td>
                    `;
                }
                tableBody.appendChild(row);
            });

            // Adicionar evento aos botões "Devolver Item"
            document.querySelectorAll('.devolver-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.getAttribute('data-id'); // Pegar o ID do item
                    fetch('devolver.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + encodeURIComponent(itemId)
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json(); // Supondo que devolver.php retorna JSON
                        } else {
                            throw new Error('Erro ao processar a requisição.');
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Item devolvido com sucesso!');
                            const buttonCell = button.closest('td'); // Encontra a célula do botão
                            buttonCell.textContent = 'Disponivel';   // Altera o conteúdo da célula
                        } else {
                            alert('Falha ao devolver o item: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocorreu um erro ao devolver o item.');
                    });
                });
            });

            document.getElementById('table1').classList.remove('hidden');
            document.querySelector('.box2').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
    });
});