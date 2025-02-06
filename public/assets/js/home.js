document.addEventListener("DOMContentLoaded", function () {

    const statNumbers = document.querySelectorAll(".stat-number");

    const startCounter = (entry, observer) => {
        if (entry.isIntersecting) {
            let target = entry.target;
            let targetNumber = target.getAttribute("data-target");
            let count = 0;
            let step = Math.ceil(targetNumber / 50);

            let updateCounter = setInterval(() => {
                count += step;
                if (count >= targetNumber) {
                    count = targetNumber;
                    clearInterval(updateCounter);
                }
                target.textContent = count;
            }, 50);

            observer.unobserve(target);
        }
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => startCounter(entry, observer));
    }, { threshold: 0.5 });

    statNumbers.forEach(stat => observer.observe(stat));
});
