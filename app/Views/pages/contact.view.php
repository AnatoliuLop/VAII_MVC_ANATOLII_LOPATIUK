<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<!-- Подключение отдельного CSS для контактов -->
<link rel="stylesheet" href="/assets/css/contacts.css">

<main class="с_kontakt-content">
    <section class="about-us">
        <h2>O nás</h2>
        <p>Autoškola PRO je moderná a profesionálna autoškola v Žiline, ktorá ponúka kvalitné výcvikové kurzy pre všetky kategórie vodičských oprávnení. Naši skúsení inštruktori vám pomôžu získať potrebné zručnosti a istotu za volantom.</p>

    </section>

    <section class="contact-details">
        <h2>Kontaktujte nás</h2>
        <p>Ak máte otázky, neváhajte nás kontaktovať na telefónnom čísle alebo e-mailovej adrese uvedenej nižšie.</p>
        <ul>
            <li><strong>Telefón:</strong> (+421) 950 373 660</li>
            <li><strong>Email:</strong> autoskola@zilina.sk</li>
        </ul>
    </section>

    <section class="google-map">
        <h2>Kde nás nájdete?</h2>
        <iframe
                src="https://www.google.com/maps/embed?pb=..."
                width="100%" height="300" style="border:0;" allowfullscreen=""
                loading="lazy">
        </iframe>
    </section>

    <section class="faq">
        <h2>Často kladené otázky (FAQ)</h2>
        <div class="faq-item">
            <button class="faq-question">Ako dlho trvá kurz?</button>
            <div class="faq-answer">Závisí od kategórie, ale priemerne 6–8 týždňov.</div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Aké dokumenty potrebujem na registráciu?</button>
            <div class="faq-answer">Občiansky preukaz a zdravotnú prehliadku.</div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Koľko stojí kurz vodičského oprávnenia?</button>
            <div class="faq-answer">Ceny závisia od kategórie a sú uvedené v sekcii "Kurzy".</div>
        </div>
    </section>

    <section class="gallery">
        <h2>Fotogaléria</h2>
        <div class="gallery-container">
            <img src="/assets/images/Autoskola_Vycvik.webp" alt="Výcvik">
            <img src="/assets/images/Jazdy.jpg" alt="Jazdy">
            <img src="/assets/images/driving-instructors.jpg" alt="Naši inštruktori">
        </div>
    </section>

    <section class="reviews">
        <h2>Hodnotenia našich študentov</h2>
        <div class="review">
            <p><strong>Marek K.</strong> ⭐⭐⭐⭐⭐</p>
            <p>Vynikajúca autoškola, skvelí inštruktori a moderné autá!</p>
        </div>
        <div class="review">
            <p><strong>Petra S.</strong> ⭐⭐⭐⭐</p>
            <p>Som spokojná, všetko prebiehalo profesionálne a organizovane.</p>
        </div>
    </section>
</main>

<script src="/assets/js/faq_toggle.js"></script>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
