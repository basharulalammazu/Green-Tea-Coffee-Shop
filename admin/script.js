document.addEventListener("DOMContentLoaded", () => {
    const userBtn = document.getElementById("user-btn");
    const menuBtn = document.getElementById("menu-btn");
    const userBox = document.getElementById("user-box");
    const navbar = document.querySelector(".navbar");

    // Toggle user box visibility
    if (userBtn && userBox) {
        userBtn.addEventListener("click", () => {
            userBox.classList.toggle("active");
        });
    }

    // Toggle menu visibility
    if (menuBtn && navbar) {
        menuBtn.addEventListener("click", () => {
            navbar.classList.toggle("active");
        });
    }

    // Close user box or menu if clicked outside
    document.addEventListener("click", (e) => {
        if (!userBox.contains(e.target) && !userBtn.contains(e.target)) {
            userBox.classList.remove("active");
        }
        if (!navbar.contains(e.target) && !menuBtn.contains(e.target)) {
            navbar.classList.remove("active");
        }
    });
});


// Function to toggle edit mode
function toggleEditMode() {
    const displayMode = document.querySelector('.display-mode');
    const editMode = document.querySelector('.edit-mode');
    
    // Toggle the visibility by changing the hidden class
    displayMode.classList.toggle('hidden');
    editMode.classList.toggle('hidden');
}
