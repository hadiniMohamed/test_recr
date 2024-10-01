document.addEventListener('DOMContentLoaded', function() {
    const enseigneSelect = document.getElementById('enseigne');
    const filterVille = document.getElementById('filter-ville');
    const filterProduit = document.getElementById('filter-produit');
    const filterQuantite = document.getElementById('filter-quantite');
    const filterRevenue = document.getElementById('filter-revenue');
    const filterDate = document.getElementById('filter-date');
    const tableBody = document.querySelector('tbody');

    function loadStockMovements(enseigne) {
        fetch(`./api/fetch_data.php?enseigne=${enseigne}`)
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data; 
                applyFilters(); 
            });
    }

    loadStockMovements('Super U');

    enseigneSelect.addEventListener('change', function() {
        loadStockMovements(this.value);
    });

    function applyFilters() {
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const ville = row.cells[0].textContent.toLowerCase();
            const produit = row.cells[1].textContent.toLowerCase();
            const quantite = row.cells[2].textContent.toLowerCase();
            const revenue = row.cells[3].textContent.toLowerCase();
            const date = row.cells[4].textContent.toLowerCase();

            // Filtering based on the values of filter fields
            const isVilleMatch = ville.includes(filterVille.value.toLowerCase());
            const isProduitMatch = produit.includes(filterProduit.value.toLowerCase());
            const isQuantiteMatch = quantite.includes(filterQuantite.value.toLowerCase());
            const isRevenueMatch = revenue.includes(filterRevenue.value.toLowerCase());
            const isDateMatch = date.includes(filterDate.value.toLowerCase());

            // Show or hide the line based on filters
            if (isVilleMatch && isProduitMatch && isQuantiteMatch && isRevenueMatch && isDateMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Adds events to filter fields
    filterVille.addEventListener('input', applyFilters);
    filterProduit.addEventListener('input', applyFilters);
    filterQuantite.addEventListener('input', applyFilters);
    filterRevenue.addEventListener('input', applyFilters);
    filterDate.addEventListener('input', applyFilters);
});
