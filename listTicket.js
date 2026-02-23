console.log("listTicket.js initiated");

const checkboxes = document.querySelectorAll('input[type="checkbox"][data-filter]');
const items = document.querySelectorAll('.ticket');

function applyFilters() {
    const activeFilters = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.dataset.filter);

    items.forEach(item => {
        const tags = item.dataset.tags.split(' ');

        const matches =
            activeFilters.length === 0 ||
            activeFilters.every(filter => tags.includes(filter));

        item.classList.toggle('hidden', !matches);
    });
}

checkboxes.forEach(cb => cb.addEventListener('change', applyFilters));
