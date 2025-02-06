document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchCars");
    const searchButton = document.getElementById("searchBtn");
    const carsContainer = document.getElementById("carsContainer");

    function searchCars() {
        const query = searchInput.value.trim();
        if (query.length === 0) {
            return;
        }

        fetch(`?url=car/search&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                carsContainer.innerHTML = ""; // Очищаем контейнер

                if (data.length === 0) {
                    carsContainer.innerHTML = "<p>Nenašli sa výsledky.</p>";
                    return;
                }

                data.forEach(car => {
                    carsContainer.innerHTML += `
                        <div class="car-card">
                            <img src="${car.photo_path}" alt="Fotka auta" class="car-photo">
                            <h3>${car.brand} ${car.model}</h3>
                            <p><strong>Palivo:</strong> ${car.fuel_type}</p>
                            <p><strong>Rok:</strong> ${car.year}</p>
                            <p><strong>Evidenčné číslo:</strong> ${car.license_plate}</p>
                        </div>`;
                });
            })
            .catch(error => console.error("Chyba pri hľadaní áut:", error));
    }

    searchButton.addEventListener("click", searchCars);
    searchInput.addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            searchCars();
        }
    });
});
