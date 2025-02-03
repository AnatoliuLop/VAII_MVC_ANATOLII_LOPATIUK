function showCourseDetails(courseId) {
    fetch(`?url=course/details&id=${courseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            document.getElementById("courseTitle").innerText = data.title;
            document.getElementById("courseFullDescription").innerText = data.full_description; // ✅ правильное поле
            document.getElementById("courseModal").style.display = "flex";
        })
        .catch(error => console.error("Chyba pri načítaní detailov kurzu:", error));
}


function closeModal() {
    document.getElementById("courseModal").style.display = "none";
}
