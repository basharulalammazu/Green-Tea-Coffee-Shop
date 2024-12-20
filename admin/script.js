document.addEventListener("DOMContentLoaded", function() {
    // Check if the elements exist before adding event listeners
    let header = document.querySelector('.header');

    function fixedNavbar() {
        if (header) {
            header.classList.toggle('scrolled', window.pageYOffset > 0);
        }
    }

    fixedNavbar();
    window.addEventListener('scroll', fixedNavbar);

    const userBtn = document.getElementById("user-btn");
    const userBox = document.getElementById("user-box");

    // Add click event to toggle the visibility of the user box
    userBtn.addEventListener("click", () => {
        if (userBox.style.display === "none" || userBox.style.display === "") {
            userBox.style.display = "block";
        } else {
            userBox.style.display = "none";
        }
    });

    // Optional: Close the user box when clicking outside of it
    document.addEventListener("click", (e) => {
        if (!userBox.contains(e.target) && e.target !== userBtn) {
            userBox.style.display = "none";
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
