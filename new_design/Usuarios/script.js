/*document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleSidebar = document.getElementById("toggleSidebar");
    const mainContent = document.getElementById("mainContent");
    const tabsContainer = document.getElementById("tabs");
    const contentContainer = document.getElementById("content");



document.getElementById("novoUsuarioLink").addEventListener("click", function() {
    document.getElementById("conteudo").innerHTML = "<p>Novo Usuário</p>";
});

document.getElementById("todosUsuariosLink").addEventListener("click", function() {
    document.getElementById("conteudo").innerHTML = "<p>Todos os Usuários</p>";
});

})

// Função para carregar o conteúdo do submenu
function carregarConteudo(tabId) {
    let conteudo = "";

    // Define o conteúdo com base no submenu clicado
    switch (tabId) {
        case "cadastro-itens":
            conteudo = document.getElementById("cadastro-itens-content").innerHTML;
            break;
        case "todos-itens":
            conteudo = document.getElementById("todos-itens-content").innerHTML;
            break;
        case "itens-disponiveis":
            conteudo = document.getElementById("itens-disponiveis-content").innerHTML;
            break;
        case "itens-quebrados":
            conteudo = document.getElementById("itens-quebrados-content").innerHTML;
            break;
        case "nova-movimentacao":
            conteudo = document.getElementById("nova-movimentacao-content").innerHTML;
            break;
        case "movimentacao-ativa":
            conteudo = document.getElementById("movimentacao-ativa-content").innerHTML;
            break;
        case "movimentacao-encerrada":
            conteudo = document.getElementById("movimentacao-encerrada-content").innerHTML;
            break;
        case "nova-manutencao":
            conteudo = document.getElementById("nova-manutencao-content").innerHTML;
            break;
        case "manutencao":
            conteudo = document.getElementById("manutencao-content").innerHTML;
            break;
        case "novo-usuario":
            conteudo = document.getElementById("novo-usuario-content").innerHTML;
            break;
        case "todos-usuarios":
            conteudo = document.getElementById("todos-usuarios-content").innerHTML;
            break;
        default:
            conteudo = `<h2>Conteúdo não encontrado</h2>`;
            break;
    }

    // Exibe o conteúdo na área principal
    contentContainer.innerHTML = conteudo;
}
       
document.getElementById("todosUsuariosLink").addEventListener("click", function(event) {
            event.preventDefault(); // Evita comportamento padrão do link
            let content = document.getElementById("novoUsuario");

            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        });*/

        /*document.getElementById("NovosUsuarios").addEventListener("click", function(event) {
            event.preventDefault(); // Evita comportamento padrão do link
            let content = document.getElementById("novoUsuario");

            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        });
        */
        
        // Adiciona um evento de clique ao link "Novo Item"
        document.getElementById("NovosUsuarioslink").addEventListener("click", function(event) {
           event.preventDefault(); // Impede o comportamento padrão do link

           // Exibe ambos os contêineres
           document.getElementById("novoUsuario").style.display = "block";
           document.getElementById("usuarios").style.display = "block";
        });
   