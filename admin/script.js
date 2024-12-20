const header = document.querySelector('header');

function fixedNavbar(){
header.classList.toggle('scrolled', window.pageYOffset > 0)
}

fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySlector('#menu-btn');

menu. addEventListener('click', function(){
let nav = document.querySelector('.navbar');
nav.classList.toggle('active');

})

let userBtn = document.querySelector('#user-btn');

userBtn. addEventListener('click', function(){
let userBox = document.querySelector('.profile-detail');
userBox.classList.toggle('active');
})

function toggleEditMode() {
    const displayMode = document.querySelector('.display-mode');
    const editMode = document.querySelector('.edit-mode');
    
    // Toggle the visibility by changing the hidden class
    displayMode.classList.toggle('hidden');
    editMode.classList.toggle('hidden');
}