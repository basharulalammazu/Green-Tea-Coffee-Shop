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

function togglePasswordMode(){
    const displayMode = document.querySelector('.display-mode');
    const passwordMode = document.querySelector('.password-mode');
    displayMode.classList.toggle('hidden');
    passwordMode.classList.toggle('hidden');
}


//---------------------------Amin Profile Update----------------------------
// Function to enable/disable the submit button
function checkFormChanges(orginalName, orginalEmail, orginalPhone) {
    const name = document.querySelector('input[name="name"]').value;
    const email = document.getElementById('email').value;
    const phone = document.querySelector('input[name="phone"]').value;
    const image = document.querySelector('input[name="image"]').value;
    console.log(email);
    console.log(orginalPhone);


    const isChanged =
        name !== orginalName ||
        email !== orginalEmail ||
        phone !== orginalPhone ||
        image !== "";

    document.getElementById('submit').disabled = !isChanged;

    // Validate email if it has changed
    if (email !== orginalEmail)
        checkUserEmail();
    
}

//--------------------------------------Admin Email Availability--------------------------------------
function checkUserEmail() {
    $.ajax({
        url: "../check_availability.php", // Path to the PHP file
        type: "POST",
        data: { email: $("#email").val() }, // Send the email as POST data
        success: function(data) {
            // Display the feedback message in the #check-email span
            $("#check-email").html(data);
        },
        error: function() {
            console.error("Error checking email availability.");
        }
    });
}

