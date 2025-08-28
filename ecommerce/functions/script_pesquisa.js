document.addEventListener("DOMContentLoaded", function() {
    const rowsPerPage = 2;
    const table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
    const rows = table.getElementsByClassName('paginacao');
    const paginationControls = document.getElementById("pagination-controls");

    let currentPage = 1;
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function displayRows(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = i >= start && i < end ? '' : 'none';
        }
    }

    function setupPagination() {
        paginationControls.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.add('pagination-button');
            btn.addEventListener('click', function() {
                currentPage = i;
                displayRows(currentPage);
                updatePagination();
            });

            if (i === currentPage) {
                btn.classList.add('active');
            }

            paginationControls.appendChild(btn);
        }
    }

    function updatePagination() {
        const buttons = paginationControls.getElementsByClassName('pagination-button');
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.toggle('active', i + 1 === currentPage);
        }
    }

    // Inicialização
    displayRows(currentPage);
    setupPagination();
});

document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.getElementById('Select');

    // Função para obter parâmetros da URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Função para definir o valor selecionado
    function setSelectedOption() {
        const selectedValue = getQueryParam('selected');
        if (selectedValue) {
            selectElement.value = selectedValue;
        }
    }

    // Configura o valor selecionado ao carregar a página
    setSelectedOption();

    // Atualiza a URL e recarrega a página quando o valor muda
    selectElement.addEventListener('change', function() {
        const selectedValue = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('selected', selectedValue);
        window.location.href = url.toString();
    });
});
