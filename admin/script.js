document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('user-btn');
    const menuBtn = document.getElementById('menu-btn');
    const userBox = document.getElementById('user-box');
    const navbar = document.querySelector('.navbar');

    // Toggle user-box visibility
    userBtn.addEventListener('click', () => {
        userBox.classList.toggle('active');
        navbar.classList.remove('active'); // Ensure the navbar is not visible
    });

    // Toggle navbar visibility
    menuBtn.addEventListener('click', () => {
        navbar.classList.toggle('active');
        userBox.classList.remove('active'); // Ensure the user-box is not visible
    });

    // Hide both when clicking outside
    document.addEventListener('click', (e) => {
        if (!userBtn.contains(e.target) && !userBox.contains(e.target)) {
            userBox.classList.remove('active');
        }
        if (!menuBtn.contains(e.target) && !navbar.contains(e.target)) {
            navbar.classList.remove('active');
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