document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logoutButton");

    if (logoutButton) {
        logoutButton.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("Kliknutie na odhlásenie - AJAX spustený");

            fetch("?url=user/logout", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Odhlásenie úspešné - stránka sa neobnoví"); // ✅ Проверка
                        document.querySelector(".user-block").innerHTML = '<a href="?url=user/login" class="btn btn-sm btn-primary login-btn">Prihlásiť</a>'; // ✅ Меняем кнопку
                    } else {
                        console.error("Chyba pri odhlásení:", data.error);
                    }
                })
                .catch(error => console.error("Chyba pri odhlásení:", error));
        });
    }
});
