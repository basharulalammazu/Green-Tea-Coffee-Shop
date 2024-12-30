document.addEventListener("DOMContentLoaded", () => {
    const userBtn = document.getElementById("user-btn");
    const menuBtn = document.getElementById("menu-btn");
    const userBox = document.getElementById("user-box");
    const navbar = document.querySelector(".navbar");

    console.log("User Button:", userBtn); // Should log the button element or null
    console.log("Menu Button:", menuBtn); // Should log the button element or null
    console.log("User Box:", userBox);   // Should log the user box element or null
    console.log("Navbar:", navbar);      // Should log the navbar element or null

    // Toggle user box visibility
    if (userBtn && userBox) {
        userBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent event bubbling
            console.log("User button clicked"); // Debugging
            userBox.classList.toggle("active");
        });
    } else {
        console.error("User button or user box not found!");
    }

    // Toggle menu visibility
    if (menuBtn && navbar) {
        menuBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent event bubbling
            console.log("Menu button clicked"); // Debugging
            navbar.classList.toggle("active");
        });
    } else {
        console.error("Menu button or navbar not found!");
    }

    // Close user box or menu if clicked outside
    document.addEventListener("click", (e) => {
        if (userBox && !userBox.contains(e.target) && !userBtn.contains(e.target)) {
            console.log("Click outside user box");
            userBox.classList.remove("active");
        }
        if (navbar && !navbar.contains(e.target) && !menuBtn.contains(e.target)) {
            console.log("Click outside navbar");
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


function productImageUpdate(event) {
    const input_file = event.target; 
    const product_image = document.getElementById('product_image'); 

    // Check if a file is selected
    if (input_file.files && input_file.files[0]) 
        product_image.src = URL.createObjectURL(input_file.files[0]);
    
}