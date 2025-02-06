document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("?url=user/loginProcess", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateUIAfterLogin(); // Aktualizácia rozhrania bez obnovenia stránky
            } else {
                document.getElementById("login-error").innerText = data.error;
                document.getElementById("login-error").style.display = "block";
            }
        })
        .catch(error => console.error("Chyba pri prihlasovaní:", error));
});

// Funkcia na aktualizáciu UI po prihlásení
function updateUIAfterLogin() {
    fetch("?url=user/status") // Načítavame informácie o používateľovi
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                document.getElementById("loginForm").style.display = "none";
                const statusDiv = document.createElement("div");
                statusDiv.innerHTML = `<p>Prihlásený ako <strong>${data.username}</strong></p>
                                       <button id="logoutButton" class="btn btn-danger">Odhlásiť sa</button>`;
                document.querySelector(".styled-form").appendChild(statusDiv);

                document.getElementById("logoutButton").addEventListener("click", logoutUser);
            }
        });
}


