function showEnrollForm(courseId) {
    document.getElementById("course_id").value = courseId;
    document.getElementById("enrollModal").style.display = "block";
}

function closeEnrollForm() {
    document.getElementById("enrollModal").style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("enrollModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
