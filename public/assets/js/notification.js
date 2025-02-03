class Notification {
    static show(message, type = "success") {
        let messageBox = document.createElement("div");
        messageBox.classList.add("notification-box", type);

        messageBox.innerText = message;
        document.body.appendChild(messageBox);

        setTimeout(() => {
            messageBox.classList.add("fade-out");
            setTimeout(() => messageBox.remove(), 500);
        }, 4000);
    }
}

// Автоматически показываем ошибки или успех из PHP-сессии
document.addEventListener("DOMContentLoaded", function () {
    const errors = JSON.parse(document.body.dataset.errors || "[]");
    const success = document.body.dataset.success || "";

    if (errors.length) {
        errors.forEach(error => Notification.show(error, "error"));
    }
    if (success) {
        Notification.show(success, "success");
    }
});
