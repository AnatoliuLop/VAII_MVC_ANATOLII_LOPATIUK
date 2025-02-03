<?php require __DIR__ . '/../layouts/header.view.php'; ?>

<main class="courses-content">
    <div>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="?url=course/create" class="btn btn-primary" style="float: right; margin: 10px;">Pridať kurz</a>
        <?php endif; ?>
        <h2 class="stranka-title">Naše Kurzy</h2>
    </div>

    <div class="courses-container">
        <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <img src="<?= htmlspecialchars($course['photo_path']) ?>" alt="Fotka kurzu" class="course-photo">
                <h3><?= htmlspecialchars($course['title']) ?></h3>
                <p><?= htmlspecialchars($course['description']) ?></p>
                <p><strong>Trvanie:</strong> <?= htmlspecialchars($course['duration']) ?> dní</p>
                <p>
                    <strong>Cena:</strong>
                    <?php if (!empty($course['discounted_price']) && $course['discounted_price'] < $course['price']): ?>
                        <span style="text-decoration: line-through; color: red;"><?= $course['price'] ?>€</span>
                        <strong style="color: green;"><?= $course['discounted_price'] ?>€</strong>
                    <?php else: ?>
                        <strong><?= $course['price'] ?>€</strong>
                    <?php endif; ?>
                </p>

                <button class="button_Courses" onclick="showCourseDetails(<?= $course['id'] ?>)">Viac informácií</button>
                <a href="?url=enroll/form&course_id=<?= $course['id'] ?>" class="button_Courses btn_prihlasitSa">Prihlásiť sa</a>



                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="admin-btns">
                        <a href="?url=course/edit&id=<?= $course['id'] ?>" class="btn btn-warning">Upraviť</a>
                        <a href="?url=course/delete&id=<?= $course['id'] ?>" class="btn btn-danger" onclick="return confirm('Naozaj chcete odstrániť tento kurz?');">Vymazať</a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Модальное окно с полным описанием курса -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="courseTitle"></h3>
            <p id="courseFullDescription"></p>
        </div>
    </div>

</main>

<script src="/assets/js/courses.js"></script>
<script src="/assets/js/enroll.js"></script>

<?php require __DIR__ . '/../layouts/footer.view.php'; ?>
