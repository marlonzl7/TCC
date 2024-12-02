// Botão para abrir/fechar a sidebar
document.getElementById('open_btn').addEventListener('click', function () {
    // Alterna a classe 'open-sidebar'
    document.getElementById('sidebar').classList.toggle('open-sidebar');
    
    // Verifica se a sidebar está aberta ou fechada e salva no localStorage
    const sidebarOpen = document.getElementById('sidebar').classList.contains('open-sidebar');
    localStorage.setItem('sidebarOpen', sidebarOpen); // true se aberta, false se fechada
});

// Ao carregar a página, verifica o estado da sidebar no localStorage
const sidebarOpen = localStorage.getItem('sidebarOpen') === 'true'; // Verifica se é 'true'
if (sidebarOpen) {
    document.getElementById('sidebar').classList.add('open-sidebar'); // Adiciona a classe se estava aberta
}

// Seleciona todos os itens da sidebar
const sideItems = document.querySelectorAll('.side-item');

// Adiciona um evento de clique em cada item
sideItems.forEach(item => {
    item.addEventListener('click', function() {
        // Remove a classe 'active' de todos os itens
        sideItems.forEach(el => el.classList.remove('active'));
        
        // Adiciona a classe 'active' no item clicado
        this.classList.add('active');

        // Armazena o link clicado no localStorage
        const link = this.querySelector('a').getAttribute('href');
        localStorage.setItem('activeLink', link);
    });
});

// Ao carregar a página, verifica se há um item ativo no localStorage
const activeLink = localStorage.getItem('activeLink');
if (activeLink) {
    sideItems.forEach(item => {
        const link = item.querySelector('a').getAttribute('href');
        if (link === activeLink) {
            item.classList.add('active');
        }
    });
}
