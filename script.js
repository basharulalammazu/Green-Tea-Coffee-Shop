document.addEventListener("DOMContentLoaded", function () {
    /* Menu bar slider */
    const header = document.querySelector('header');
    function fixedNavbar() {
        header.classList.toggle('scroll', window.pageYOffset > 0);
    }
    fixedNavbar();
    window.addEventListener('scroll', fixedNavbar);

    const menu = document.querySelector('#menu-btn');
    const userBtn = document.querySelector('#user-btn');

    if (menu) {
        menu.addEventListener('click', function () {
            const nav = document.querySelector('.navbar');
            nav.classList.toggle('active');
        });
    }

    if (userBtn) {
        userBtn.addEventListener('click', function () {
            const userBox = document.querySelector('.user-box');
            userBox.classList.toggle('active');
        });
    }

    /* Home slider */
    const slider = document.querySelector('.slider');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');

    function scrollRight() {
        if (slider && slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
            slider.scrollTo({ left: 0, behavior: "smooth" });
        } else {
            slider.scrollBy({ left: window.innerWidth, behavior: "smooth" });
        }
    }

    function scrollLeft() {
        if (slider) {
            slider.scrollBy({ left: -window.innerWidth, behavior: "smooth" });
        }
    }

    if (slider) {
        let timerId = setInterval(scrollRight, 7000);
        function resetTimer() {
            clearInterval(timerId);
            timerId = setInterval(scrollRight, 7000);
        }

        if (leftArrow) {
            leftArrow.addEventListener('click', function () {
                scrollLeft();
                resetTimer();
            });
        }

        if (rightArrow) {
            rightArrow.addEventListener('click', function () {
                scrollRight();
                resetTimer();
            });
        }
    }

    /* Testimonial slider */
    let slides = document.querySelectorAll('.testimonial-item');
    let index = 0;

    function nextSlide() {
        slides[index].classList.remove('active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('active');
    }

    function prevSlide() {
        slides[index].classList.remove('active');
        index = (index - 1 + slides.length) % slides.length;
        slides[index].classList.add('active');
    }

    if (slides.length > 0) {
        document.querySelector('.right-arrow').addEventListener('click', nextSlide);
        document.querySelector('.left-arrow').addEventListener('click', prevSlide);
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector('.slider');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');

    // Check if slider and arrows exist
    if (!slider || !leftArrow || !rightArrow) {
        console.error("Slider or arrows are missing from the DOM.");
        return;
    }

    // Testimonial Items
    const slides = document.querySelectorAll('.testimonial-item');
    let index = 0;

    // Helper to update active class
    function updateSlides() {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    // Scroll Right
    function nextSlide() {
        index = (index + 1) % slides.length;
        updateSlides();
    }

    // Scroll Left
    function prevSlide() {
        index = (index - 1 + slides.length) % slides.length;
        updateSlides();
    }

    // Attach event listeners
    rightArrow.addEventListener('click', nextSlide);
    leftArrow.addEventListener('click', prevSlide);

    // Initialize active slide
    updateSlides();
});

$('.order').click(function (e) {
	let button = $(this); 
	if (!button.hasClass("animate")) {
		button.addClass('animate');
		setTimeout(() => {
			button.removeClass('animate');
		}, 10000)		  
	}
});


//------------------Customer Profile Edit Button------------------------
function toggleEditMode() {
    const displayMode = document.querySelector('.display-mode');
    const editMode = document.querySelector('.edit-mode');
    displayMode.classList.toggle('hidden');
    editMode.classList.toggle('hidden');
}

//------------------Customer Profile Password Button------------------------
function togglePasswordMode(isClick = false, isPasswordUpdated = false, cancel = false) 
{
    const displayMode = document.querySelector('.display-mode');
    const passwordMode = document.querySelector('.password-mode');

    if (isPasswordUpdated) 
    {
        displayMode.classList.remove('hidden');
        passwordMode.classList.add('hidden');
    } 
    else if (isClick || cancel)
    {
        displayMode.classList.toggle('hidden');
        passwordMode.classList.toggle('hidden');
    }

}

document.addEventListener("DOMContentLoaded", function () {
    const scrollToTopButton = document.getElementById('scrollToTop');

    if (scrollToTopButton) {
        // Show or hide the button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = 'flex'; // Show the button
            } else {
                scrollToTopButton.style.display = 'none'; // Hide the button
            }
        });

        // Scroll to top when the button is clicked
        scrollToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    } else {
        console.error('Scroll to Top button not found in the DOM!');
    }
});


function checkFormChanges(orginalName, orginalEmail, orginalPhone) {
    const name = document.querySelector('input[name="name"]').value;
    const email = document.getElementById('email').value;
    const phone = document.querySelector('input[name="phone"]').value;

    console.log("Current Email:", email);
    console.log("Original Email:", orginalEmail);

    // Check if any field has changed
    const isChanged =
        name !== orginalName ||
        email !== orginalEmail ||
        phone !== orginalPhone;

    // Enable or disable the submit button based on changes
    document.getElementById('submit').disabled = !isChanged;

    // Validate email ONLY if it has changed
    if (email !== orginalEmail) 
        {
        console.log("Email has changed. Checking availability...");
        checkUserEmail();
    } 
    else 
    {
        console.log("Email is the same. No need to check availability.");
        checkUserEmail(true);
    }
}



//--------------------------------------Customer Email Availability--------------------------------------
function checkUserEmail(checkEdit = false) {

    if (checkEdit)
    {
        $("#check-email").html(""); // Clear any error message when email hasn't changed
        
    }

    else
    {
        $.ajax({
            url: "check_availability.php", // Path to the PHP file
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
    
}



function passwordToggle() {
    const password = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
