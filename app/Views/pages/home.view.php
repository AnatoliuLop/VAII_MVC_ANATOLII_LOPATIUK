<?php require __DIR__ . '/../../views/layouts/header.view.php'; ?>

<main class="p-3 m-0 border-0 bd-example m-0 border-0">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item" style="background-image: url('assets/images/photo_of_team.jpg');">
                <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400">
                    <rect width="100%" height="100%" fill="none"></rect>
                </svg>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Náš Tím</h5>
                    <p>Náš tím profesionálnych inštruktorov...</p>
                </div>
            </div>
            <div class="carousel-item active" style="background-image: url('assets/images/car_images_home_page.jpg');">
                <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400">
                    <rect width="100%" height="100%" fill="none"></rect>
                </svg>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Naše autá</h5>
                    <p>Naša autoškola ponúka moderné a bezpečné vozidlá...</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('assets/images/aula_home_page.jpg');">
                <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400">
                    <rect width="100%" height="100%" fill="none"></rect>
                </svg>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Naša učebňa</h5>
                    <p>Naša moderná učebňa je vybavená najnovšími technológiami...</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</main>


<?php require __DIR__ . '/../../views/layouts/footer.view.php'; ?>
