document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchCars');
    const container = document.getElementById('carsContainer');

    if (searchBtn && searchInput && container) {
        searchBtn.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (!query) {
                alert('Zadaj text pre hľadanie.');
                return;
            }

            fetch(`?url=car/search&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    // Очищаем контейнер
                    container.innerHTML = '';
                    if (data.length === 0) {
                        container.innerHTML = '<p>Nenašli sa výsledky.</p>';
                        return;
                    }

                    data.forEach(car => {
                        const card = document.createElement('div');
                        card.classList.add('car-card');
                        card.innerHTML = `
              <img src="${car.photo_path}" alt="Fotka auta" class="car-photo">
              <h3>${car.brand} ${car.model}</h3>
              <p><strong>Palivo:</strong> ${car.fuel_type}</p>
              <p><strong>Rok:</strong> ${car.year}</p>
              <p><strong>Evidenčné číslo:</strong> ${car.license_plate}</p>
              <a href="?url=car/edit&id=${car.id}" class="btn btn-warning">Upraviť</a>
              <a href="?url=car/delete&id=${car.id}" class="btn btn-danger" onclick="return confirm('Naozaj chcete odstrániť auto?');">Vymazať</a>
            `;
                        container.appendChild(card);
                    });
                })
                .catch(err => console.error('Chyba pri fetch: ', err));
        });
    }
});
